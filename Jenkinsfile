pipeline {
    agent any

    parameters {
        choice(
            name: 'PIPELINE_TYPE',
            choices: ['SCAN_ONLY', 'SCAN_BUILD_DEPLOY'],
            description: 'Choose pipeline execution type'
        )

        gitParameter(
            name: 'BRANCH',
            type: 'PT_BRANCH',
            defaultValue: 'main',
            description: 'Choose branch to build',
            branchFilter: 'origin/(.*)',
            selectedValue: 'DEFAULT',
            sortMode: 'ASCENDING'
        )
    }

    environment {
        REPO_URL = 'http://repo.mitratel.co.id/inhouse-app/dwh-monitoring.git'
        REPO_URL_SHORT = '@repo.mitratel.co.id/inhouse-app/dwh-monitoring.git'
        BRANCH_NAME = 'master'
        APP_NAME = 'DWH Monitoring'
        APP_ID = 'DWH-Monitoring'
        SONAR_URL = 'http://sonarqube:9000'
        TARGET_URL = 'http://192.178.100.1:8000'
        AUTH_USERNAME = credentials('test-username')
        AUTH_PASSWORD = credentials('test-password')
        GIT_USERNAME = credentials('git-username-farras')
        GIT_TOKEN = credentials('git-token-farras')
        TARGET_PATH_PARENT = '/var/www'
        TARGET_PATH_CHILD = 'dwh-monitoring'
        TARGET_PATH = '/var/www/dwh-monitoring'
        SONAR_TOKEN = credentials('sonarqube-login-farras')
        REPORT_NAME = 'dast-report-dwh-monitoring.html'
        TRIVY_NAME = 'trivy-dwh-monitoring.html'
        TRIVY_FS_NAME = 'trivy-fs-dwh-monitoring.html'
        K6_NAME = 'load-performance-report-dwh-monitoring.html'
        K6_PROD_NAME = 'load-performance-report-production-dwh-monitoring.html'
        DB_DEV_HOST = credentials('db-datalake-host')
        DB_DEV_USER = credentials('db-datalake-user')
        DB_DEV_PASSWORD = credentials('db-datalake-password')
        DB_DEV_PORT = credentials('db-datalake-port')
        VM_DEV_USER = credentials('vm-dev-user')
        VM_DEV_PASSWORD = credentials('vm-dev-password')
        VM_DEV_HOST = credentials('vm-dev-host')
        VM_DEV_PATH = '/var/www/html/dwh-monitoring'
        VM_PROD_USER = credentials('vm-dwhapps-user')
        VM_PROD_PASSWORD = credentials('vm-dwhapps-password')
        VM_PROD_HOST = credentials('vm-dwhapps-host')
        VM_PROD_PATH = '/var/www/html'
        DEV_URL = 'https://dev.mitratel.co.id/dwh-monitoring'
        PROD_URL = 'https://dwhapps.mitratel.co.id'
    }

    stages {
        stage('Checkout') {
            steps {
                checkout([$class: 'GitSCM',
                    branches: [[name: "*/${BRANCH_NAME}"]],
                    userRemoteConfigs: [[
                        url: "${REPO_URL}",
                        credentialsId: 'repo-cred-farras'
                    ]]
                ])
            }
        }

        stage('SAST Scan (SonarQube)') {
            steps {
                script {
                    def scannerHome = tool 'SonarScanner'
                    withSonarQubeEnv('SSDLC Mitratel - SAST') {
                        sh """
                            ${scannerHome}/bin/sonar-scanner \\
                            -Dsonar.projectName='${APP_NAME}' \\
                            -Dsonar.projectKey='${APP_ID}' \\
                            -Dsonar.sources=. \\
                            -Dsonar.host.url='${SONAR_URL}' \\
                            -Dsonar.login='${SONAR_TOKEN}'
                        """
                    }
                }
            }
        }

        stage('Build Laravel') {
            steps {
                script {
                    sh """
                    apt update       
                    apt remove --purge php8.2 php8.2-cli php8.2-fpm php8.2-mysql php8.2-xml php8.2-mbstring php8.2-curl php8.2-zip php8.2-bcmath php8.2-sqlite3 php8.2-* -y
                    echo "Y" | apt install php7.4 php7.4-cli php7.4-fpm php7.4-mysql php7.4-xml php7.4-mbstring php7.4-curl php7.4-zip php7.4-json php7.4-bcmath
                    mkdir -p /var/www/temp
                    cd /var/www/temp
                    rm -f composer74
                    php7.4 -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
                    php7.4 composer-setup.php
                    mv composer.phar composer74
                    rm -f composer-setup.php
                    mkdir -p "${TARGET_PATH_PARENT}"
                    cd "${TARGET_PATH_PARENT}"
                    rm -rf "${TARGET_PATH_CHILD}"
                    git clone http://${GIT_USERNAME}:${GIT_TOKEN}${REPO_URL_SHORT} "${TARGET_PATH_CHILD}"
                    cd "${TARGET_PATH_CHILD}"
                    /var/www/temp/composer74 update --ignore-platform-req=ext-gd
                    /var/www/temp/composer74 install --ignore-platform-req=ext-gd
                    touch .env
                    cat > .env <<EOF
APP_NAME=CorsecOneFlux
APP_ENV=staging
APP_KEY=
APP_DEBUG=true
APP_URL=${TARGET_URL}

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=postgres
DB_HOST=${DB_DEV_HOST}
DB_PORT=${DB_DEV_PORT}
DB_DATABASE=datalake_mitratel
DB_USERNAME=${DB_DEV_USER}
DB_PASSWORD="${DB_DEV_PASSWORD}"

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DRIVER=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

ASSET_URL=${TARGET_URL}/public
UPLOAD_URL="${TARGET_PATH}/public/storage"

APIV2_URL=
APIV2_KEY=

EOF
                    php7.4 artisan key:generate
                    php7.4 artisan config:cache
                    php7.4 artisan route:cache
                    php7.4 artisan view:cache
                    """
                }
            }
        }

        stage('SCA Scan (Trivy) - Source Code') {
            steps {
                script {
                    sh """
                       trivy fs --format template --template "@/usr/local/bin/html.tpl" \\
                       --severity HIGH,CRITICAL '${TARGET_PATH}' -o ${TRIVY_NAME}
                    """
                }
            }
        }

        stage('Start Laravel') {
            steps {
                script {
                    sh """
                    cd '${TARGET_PATH}'
                    php7.4 artisan serve --host=0.0.0.0 --port=8000 & echo \$! > laravel.pid
                    sleep 10
                    """
                }
            }
        }

        stage('Runtime Scan (Trivy) - File System') {
            steps {
                script {
                    sh """
                       trivy fs --format template --template "@/usr/local/bin/html.tpl" \\
                       --severity HIGH,CRITICAL '/' -o ${TRIVY_FS_NAME}
                    """
                }
            }
        }

        // stage('Setup DAST Tools (OWASP ZAP)') {
        //     steps {
        //         script {
        //             sh '''
        //                 docker rm -f owasp || true
        //                 docker pull zaproxy/zap-stable
        //                 docker run -dt --name owasp zaproxy/zap-stable /bin/bash
        //                 docker exec owasp sh -c "mkdir -p /zap/wrk"
        //             '''
        //         }
        //     }
        // }

        // stage('DAST Scan (OWASP ZAP)') {
        //     steps {
        //         script {
        //             sh """
        //                 docker exec owasp zap-full-scan.py \\
        //                 -t ${TARGET_URL} \\
        //                 -g gen.conf \\
        //                 -r /zap/wrk/${REPORT_NAME} \\
        //                 -I \\
        //                 --hook=/zap/auth_hook.py \\
        //                 -d \\
        //                 -z "auth.loginurl=${TARGET_URL}/login \\
        //                 auth.username=${AUTH_USERNAME} \\
        //                 auth.password=${AUTH_PASSWORD} \\
        //                 auth.username_field=username auth.password_field=password \\
        //                 auth.submit_field=submit \\
        //                 auth.include=${TARGET_URL}/.* \\
        //                 spider.maxDuration=10 \\
        //                 ajaxSpider.maxDuration=5 \\
        //                 ajaxSpider.browserWait=10000"
        //             """
        //         }
        //     }
        // }

        stage('Stop Laravel') {
            steps {
                script {
                    sh """
                    cd '${TARGET_PATH}'
                    kill \$(cat laravel.pid) || true
                    rm -f laravel.pid
                    """
                }
            }
        }

        stage('Deploy to Development') {
            steps {
                script {
                    echo "Deployment ke VM Development"
                    sh """
                    apt install sshpass
                    sshpass -p '${VM_DEV_PASSWORD}' ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null ${VM_DEV_USER}@${VM_DEV_HOST} "cd '${VM_DEV_PATH}' && git pull && php artisan optimize:clear"
                    """
                }
            }
        }

        stage('Run Load & Performance Test (K6) VM Development') {
            steps {
                sh """ 
                cd '${TARGET_PATH}'
                K6_WEB_DASHBOARD=true K6_WEB_DASHBOARD_EXPORT=${K6_NAME} k6 run --env USERNAME=${AUTH_USERNAME} --env PASSWORD='${AUTH_PASSWORD}' --env URL='${DEV_URL}' k6.js
                """
            }
        }

        stage('Deploy to Production') {
            when {
                expression { params.PIPELINE_TYPE == 'SCAN_BUILD_DEPLOY' }
            }
            steps {
                script {
                    echo "Deployment ke VM Production"
                    sh """
                    apt install sshpass
                    sshpass -p '${VM_PROD_PASSWORD}' ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/nul ${VM_PROD_USER}@${VM_PROD_HOST} "cd '${VM_PROD_PATH}' && git pull && php artisan optimize:clear"
                    """
                }
            }
        }

        stage('Run Load & Performance Test (K6) VM Production') {
            when {
                expression { params.PIPELINE_TYPE == 'SCAN_BUILD_DEPLOY' }
            }
            steps {
                sh """ 
                cd '${TARGET_PATH}'
                K6_WEB_DASHBOARD=true K6_WEB_DASHBOARD_EXPORT=${K6_PROD_NAME} k6 run --env USERNAME=${AUTH_USERNAME} --env PASSWORD='${AUTH_PASSWORD}' --env URL='${PROD_URL}' k6.js
                """
            }
        }

        stage('Copy Reports') {
            steps {
                script {
                    sh """
                        mkdir -p /opt/application/trivy/reports
                        mkdir -p /opt/application/k6/reports
                        cp ${TRIVY_NAME} /opt/application/trivy/reports/${TRIVY_NAME}
                        cp ${TRIVY_FS_NAME} /opt/application/trivy/reports/${TRIVY_FS_NAME}
                        cp ${TARGET_PATH}/${K6_NAME} ./${K6_NAME}
                        cp ${TARGET_PATH}/${K6_NAME} /opt/application/k6/reports/${K6_NAME}
                    """
                }
            }
        }

        // stage('Copy Reports DAST') {
        //     steps {
        //         script {
        //             sh """
        //                 docker cp owasp:/zap/wrk/${REPORT_NAME} ./${REPORT_NAME}
        //                 mkdir -p /opt/application/owasp-zap/reports
        //                 cp ${REPORT_NAME} /opt/application/owasp-zap/reports/${REPORT_NAME}
        //             """
        //         }
        //     }
        // }

        stage('Copy Reports Production') {
            when {
                expression { params.PIPELINE_TYPE == 'SCAN_BUILD_DEPLOY' }
            }
            steps {
                script {
                    sh """
                        mkdir -p /opt/application/k6/reports
                        cp ${TARGET_PATH}/${K6_PROD_NAME} ./${K6_PROD_NAME}
                        cp ${TARGET_PATH}/${K6_PROD_NAME} /opt/application/k6/reports/${K6_PROD_NAME}
                    """
                }
            }
        }
        
    }

    post {
        always {
            archiveArtifacts artifacts: '*.html', allowEmptyArchive: false
            cleanWs()
        }
    }
}
