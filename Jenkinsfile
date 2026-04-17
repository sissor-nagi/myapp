pipeline {
    agent any

    stages {

        stage('Clone') {
            steps {
                git branch: 'main', url: 'https://github.com/sissor-nagi/myapp.git'
            }
        }

        stage('Build') {
            steps {
                sh 'echo "Build OK"'
            }
        }

        stage('Deploy') {
            steps {
                sh 'cp -r * /var/www/html/myapp/'
            }
        }
    }
}
