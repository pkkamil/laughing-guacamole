FROM nginx:1.25.2-alpine

# Copy the public directory
# COPY ./public/ /app/public/
COPY . /app/

# Copy the nginx config file
COPY ./docker/nginx/nginx.conf /etc/nginx/conf.d/default.conf
