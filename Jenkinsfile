pipeline {
    agent any

    environment {
        APP_NAME = "myapp"
        IMAGE_NAME = "myapp-image"
        SONAR_HOST = "http://localhost:9000"
    }

    stages {
        stage('Checkout') {
            steps {
                git branch: 'main', 
                    url: 'https://github.com/sissor-nagi/myapp.git'
            }
        }

        stage('SonarQube Analysis') {
            steps {
                withSonarQubeEnv('SonarQube') {
                    sh '''
                        # Vérifier/installer sonar-scanner
                        if ! command -v sonar-scanner &> /dev/null; then
                            echo "Installing sonar-scanner..."
                            wget -q https://binaries.sonarsource.com/Distribution/sonar-scanner-cli/sonar-scanner-cli-5.0.1.3006-linux.zip
                            unzip -o sonar-scanner-cli-5.0.1.3006-linux.zip
                            export PATH="${PATH}:/$(pwd)/sonar-scanner-5.0.1.3006-linux/bin"
                        fi
                        
                        sonar-scanner \
                            -Dsonar.projectKey=myapp \
                            -Dsonar.sources=. \
                            -Dsonar.host.url='${SONAR_HOST}' \
                            -Dsonar.login=sqp_880fe789a9e56965b22333d839591152cc4ede6e
                    '''
                }
            }
        }

        stage('Build Docker Image') {
            steps {
                sh '''
                    docker build -t ${IMAGE_NAME}:${BUILD_NUMBER} .
                '''
            }
        }

        stage('Trivy Scan') {
            steps {
                sh '''
                    # Installer Trivy si absent
                    if ! command -v trivy &> /dev/null; then
                        echo "Installing Trivy..."
                        curl -sfL https://raw.githubusercontent.com/aquasecurity/trivy/main/contrib/install.sh | sh -s -- -b /usr/local/bin
                    fi
                    
                    trivy image --exit-code 1 --no-progress --severity HIGH,CRITICAL ${IMAGE_NAME}:${BUILD_NUMBER}
                '''
            }
        }

        stage('Deploy to Apache') {
            steps {
                sh '''
                    # Créer répertoire si inexistant
                    sudo mkdir -p /var/www/html/myapp
                    
                    # Nettoyer
                    sudo rm -rf /var/www/html/myapp/*
                    
                    # Copier fichiers (exclure fichiers sensibles)
                    sudo rsync -av \
                        --exclude="node_modules" \
                        --exclude=".git" \
                        --exclude="Dockerfile" \
                        --exclude="Jenkinsfile" \
                        ./* /var/www/html/myapp/
                    
                    # Permissions Apache
                    sudo chown -R www-data:www-data /var/www/html/myapp/
                    sudo chmod -R 755 /var/www/html/myapp/
                    
                    echo "✅ Deployment completed!"
                '''
            }
        }
    }

    post {
        always {
            sh 'docker image prune -f || true'
        }
        success {
            echo "✅ PIPELINE SUCCESS - ${APP_NAME} v${BUILD_NUMBER} deployed!"
        }
        failure {
            echo "❌ PIPELINE FAILED"
        }
    }
}
