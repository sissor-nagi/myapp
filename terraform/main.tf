terraform {
  required_providers {
    docker = {
      source  = "kreuzwerker/docker"
      version = ">= 3.0.0"
    }
  }
}

provider "docker" {}

resource "docker_image" "myapp" {
  name = "myapp-image:latest"
}

resource "docker_container" "myapp_container" {
  name  = "myapp"
  image = docker_image.myapp.name

  ports {
    internal = 80
    external = 8081
  }
}
