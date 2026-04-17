pipeline {
    agent any

    environment {
        IMAGE_NAME = "myapp-image"
        SONAR_PROJECT = "myapp"
    }

    stages {

        stage('Checkout') {
            steps {
                git branch: 'main', url: 'https://github.com/sissor-nagi/myapp.git'
            }
        }

        stage('Clean Workspace') {
            steps {
                sh 'rm -rf /var/www/html/myapp/*'
            }
        }

        stage('SonarQube Analysis') {
    steps {
        withSonarQubeEnv('SonarQube') {
            withEnv(["PATH+SONAR=/opt/sonar-scanner/bin"]) {
                sh '''
                sonar-scanner \
                -Dsonar.projectKey=myapp \
                -Dsonar.sources=. \
                -Dsonar.host.url=http://localhost:9000 \
                -Dsonar.login=sqp_880fe789a9e56965b22333d839591152cc4ede6e
                    """
                }
            }
        }

        stage('Build Docker Image') {
            steps {
                sh 'docker build -t $IMAGE_NAME .'
            }
        }

        stage('Trivy Security Scan') {
            steps {
                sh 'trivy image --exit-code 0 --severity HIGH,CRITICAL $IMAGE_NAME'
            }
        }

        stage('Deploy to Apache') {
            steps {
                sh 'cp -r * /var/www/html/myapp/'
            }
        }
    }

    post {
        success {
            echo "Pipeline SUCCESS ✅"
        }
        failure {
            echo "Pipeline FAILED ❌"
        }
    }
}
