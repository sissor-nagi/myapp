pipeline {
    agent any

    stages {

        stage('Clone') {
            steps {
                git url: 'https://github.com/sissor-nagi/myapp.git', branch: 'main'
            }
        }

        stage('SonarQube Analysis') {
            steps {
                withSonarQubeEnv('SonarQube') {
                    sh '''
                    sonar-scanner \
                    -Dsonar.projectKey=myapp \
                    -Dsonar.sources=. \
                    -Dsonar.host.url=http://localhost:9000 \
                    -Dsonar.login=sqa_3792a41d56f3ea304ec668bd4f8f2ff6829709c3
                    '''
                }
            }
        }

        stage('Build Docker') {
            steps {
                sh 'docker build -t myapp-image .'
            }
        }

        stage('Trivy Scan') {
            steps {
                sh 'trivy image myapp-image'
            }
        }

        stage('Deploy') {
            steps {
                sh 'cp -r * /var/www/html/myapp/'
            }
        }
    }
}
