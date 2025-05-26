#!/bin/bash

echo " Encerrando os containers da aplicação..."

cd back-end || exit 1

docker-compose down

echo ""
echo "Containers parados e removidos com sucesso."
