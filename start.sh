#!/bin/bash

echo "🚀 Iniciando o ambiente de containers..."
cd back-end || exit 1


docker-compose down -v

docker-compose up -d --build


echo -n "⏳ Subindo containers"
for i in {1..10}; do
    echo -n "."
    sleep 0.5
done
echo ""

echo ""
echo "✅ Containers iniciados com sucesso!"
echo "🔗 API Laravel:     http://localhost:8989"
echo "🔗 Vue Frontend:    http://localhost:5173"
echo "🔗 phpMyAdmin:      http://localhost:8181"
echo "📄 Swagger (Documentação da API): http://localhost:8989/api/documentation"
