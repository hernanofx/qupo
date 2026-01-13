# Build stage
FROM node:18-alpine AS build
WORKDIR /app
COPY package*.json ./
RUN npm ci --legacy-peer-deps
COPY . .
RUN npm run build

# Production stage
FROM nginx:stable-alpine
# Copy nginx config for SPA routing
RUN mkdir -p /etc/nginx/conf.d
RUN echo 'server {
  listen 80;
  location / {
    root /usr/share/nginx/html;
    try_files \$uri /index.html;
  }
}' > /etc/nginx/conf.d/default.conf
# Copy built files
COPY --from=build /app/dist /usr/share/nginx/html
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]
