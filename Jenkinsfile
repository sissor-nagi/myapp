pipeline {
    agent any

    stages {

        stage('Checkout') {
            steps {
                git branch: 'main', url: 'https://github.com/sissor-nagi/myapp.git'
            }
        }

        stage('SonarQube Analysis') {
            steps {
                sh '''
                sonar-scanner \
                -Dsonar.projectKey=myapp \
                -Dsonar.projectName=myapp \
                -Dsonar.sources=. \
                -Dsonar.host.url=http://localhost:9000 \
                -Dsonar.login=sqp_40735975e6563fa0c9593dc63dbb778223012200
                '''
            }
        }

        stage('Build Docker Image') {
            steps {
                sh 'docker build -t myapp-image:latest .'
            }
        }

        stage('Trivy Scan') {
            steps {
                sh '''
                trivy image --exit-code 1 --severity HIGH,CRITICAL myapp-image:latest
                '''
            }
        }

        stage('Run Container') {
            steps {
                sh '''
                docker stop myapp || true
                docker rm myapp || true
                docker run -d -p 8081:80 --name myapp myapp-image:latest
                '''
            }
        }
    }

    post {
        always {
            echo 'Pipeline terminé'
        }
        success {
            echo 'SUCCESS ✔'
        }
        failure {
            echo 'FAILED ❌ check logs'
        }
    }
}
