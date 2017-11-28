#!/usr/bin/env bash
# docker-compose build
# docker tag postgres:10 gcr.io/delter-airlines/postgres:10
# docker tag delterairlinesteam3_web:latest gcr.io/delter-airlines/team3delter:v1
docker build -t gcr.io/delter-web-app/delter-airlines:v1 .
