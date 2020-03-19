pipeline {
    agent {
        docker {
            image 'my127/php:7.2-fpm-stretch-console'
        }
    }
    stages {
        stage('Install') {
            steps { sh 'composer install' }
        }

        stage('Test') {
            parallel {
                stage('unit')       { steps { sh 'composer test-unit' } }
                stage('acceptance') { steps { sh 'composer test-acceptance' } }
                stage('standards')  { steps { sh 'composer test-quality' } }
            }
        }
    }
    post {
        always {
            sh 'rm -rf composer.lock ./vendor'
        }
    }
}
