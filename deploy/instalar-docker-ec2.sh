#!/bin/bash
# Prepara uma EC2 Ubuntu 24.04 para receber a aplicação.
# Cole este conteúdo em "Advanced details > User data" ao criar a instância,
# ou rode manualmente com: sudo bash instalar-docker-ec2.sh
set -e

apt-get update
apt-get install -y docker.io curl
systemctl enable --now docker
usermod -aG docker ubuntu

# 1 GB de swap ajuda instâncias pequenas (t3.micro) a não ficarem sem memória
if [ ! -f /swapfile ]; then
  fallocate -l 1G /swapfile
  chmod 600 /swapfile
  mkswap /swapfile
  swapon /swapfile
  echo '/swapfile none swap sw 0 0' >> /etc/fstab
fi
