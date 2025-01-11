# Shopping Application

## Technologies

- PHP / [PHPFrame](https://github.com/noah1400/PHPFrame)
- Docker & Docker Compose

### Backend structure

The routes for the backend are defined in `./backend/Routes/routes.php`

The implementations of the endpoints can be found in the controllers `./backend/App/Controllers/*.php`

### Running the application

To run the application, you need to have Docker and Docker Compose installed on your machine.
To test the kube deployment, you need to have minikube installed.

1. Enter the root directory of the project
2. Run `docker-compose up --build`
3. The application should be available at `http://localhost:5000`

#### Testing the Kubernetes deployment

1. Start minikube with `minikube start`
2. Enter the minikube context with `eval $(minikube docker-env)`
3. Build the image with `docker build -t php-backend:1.0.0 -f backend.Dockerfile .`
4. Apply the deployment with `kubectl apply -f ./k8s/deployment.yml`
5. Apply the service with `kubectl apply -f ./k8s/services.yml`
6. Apply the mysql deployment with `kubectl apply -f ./k8s/mysql.yml`
7. Apply the mysql configmap with `kubectl apply -f ./k8s/mysql-configmap.yml`
8. Access the frontend with `minikube service flask-frontend`

### 12-Factor Principles Applied

1. **Codebase**: Ein Git-Repository für die gesamte Anwendung.
2. **Dependencies**: Alle Abhängigkeiten sind klar definiert.
3. **Configuration**: Konfigurationen werden nicht im Code hartkodiert, sondern über Umgebungsvariablen und `.env` Dateien bereitgestellt.
4. **Backing Services**: Alle externen Dienste sind über Umgebungsvariablen definiert, keine festen URLs.
5. **Build, Release, Run**: Das Projekt wird in Docker-Containern ausgeführt, wodurch die Trennung von Build, Release und Run gewährleistet ist.
6. **Processes**: Die Anwendung läuft als stateless Prozesse in Containern.
7. **Port Binding**: Die Anwendung verwendet PORT-Umgebungsvariablen zum Binden der Ports.
8. **Concurrency**: Skalierbarkeit wird unterstützt.
9. **Disposability**: Container können jederzeit gestartet oder gestoppt werden.
10. **Dev/Prod Parity**: Die Entwicklungs- und Produktionsumgebung sind durch Docker weitgehend identisch.
11. **Logs**: Logs werden in der Standardausgabe der Container gespeichert und können durch Docker gelesen werden.
12. **Admin Processes**: Verwaltungsaufgaben, wie z.B. Migrationen, werden manuell durch den Container durchgeführt.


