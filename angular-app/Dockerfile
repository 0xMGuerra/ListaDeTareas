FROM node:20-alpine as node

WORKDIR /app

COPY . .

RUN npm install
RUN npm run build --include=dev

FROM nginx:alpine

COPY --from=node /app/dist/angular-app /usr/share/nginx/html

