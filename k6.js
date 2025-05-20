import http from "k6/http";
import { check, sleep } from "k6";
import { parseHTML } from "k6/html";

export const options = {
    stages: [
        { duration: "30s", target: 50 },
        { duration: "1m", target: 50 },
        { duration: "30s", target: 0 },
    ],
};

export default function () {
    
    const baseUrl = __ENV.URL;

    // Step 1: GET login page to get CSRF token
    let loginPageRes = http.get(`${baseUrl}/login`);

    // Extract CSRF token from HTML <input name="_token" value="...">
    let doc = parseHTML(loginPageRes.body);
    let csrfToken = doc.find('input[name="_token"]').first().attr("value");

    check(csrfToken, {
        "CSRF token extracted": (token) => token !== undefined,
    });

    const username = __ENV.USERNAME;
    const password = __ENV.PASSWORD;

    // Step 2: POST login with CSRF token
    const loginUrl = `${baseUrl}/login`;
    const payload = {
        username: username,
        password: password,
        _token: csrfToken,
    };

    const headers = {
        "Content-Type": "application/x-www-form-urlencoded",
    };

    let loginRes = http.post(
        loginUrl,
        Object.entries(payload)
            .map(([k, v]) => `${k}=${encodeURIComponent(v)}`)
            .join("&"),
        { headers }
    );

    check(loginRes, {
        "login status is 200 or redirected": (r) =>
            r.status === 200 || r.status === 302,
    });

    sleep(1);
}
