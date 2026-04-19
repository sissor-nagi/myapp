terraform {
  required_providers {
    docker = {
      source  = "kreuzwerker/docker"
      version = ">= 3.0.0"
    }
  }
}

provider "docker" {}

# ── Réseau partagé ──────────────────────────────────────
resource "docker_network" "myapp_network" {
  name = "myapp_network"
}

# ── Image MySQL ─────────────────────────────────────────
resource "docker_image" "mysql" {
  name = "mysql:8"
}

# ── Conteneur MySQL ─────────────────────────────────────
resource "docker_container" "mysql_container" {
  name    = "mydb"
  image   = docker_image.mysql.name
  restart = "always"

  env = [
    "MYSQL_ROOT_PASSWORD=root",
    "MYSQL_DATABASE=myapp",
    "MYSQL_USER=appuser",
    "MYSQL_PASSWORD=User@123Secure"
  ]

  ports {
    internal = 3306
    external = 3307
  }

  networks_advanced {
    name = docker_network.myapp_network.name
  }
}

# ── Image App ────────────────────────────────────────────
resource "docker_image" "myapp" {
  name = "myapp-image:latest"
}

# ── Conteneur Web ────────────────────────────────────────
resource "docker_container" "myapp_container" {
  name  = "myapp"
  image = docker_image.myapp.name

  env = [
    "DB_HOST=mydb"
  ]

  ports {
    internal = 80
    external = 8081
  }

  networks_advanced {
    name = docker_network.myapp_network.name
  }

  depends_on = [docker_container.mysql_container]
}
