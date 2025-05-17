FROM nginx:1.25.2-alpine

# Copy the public directory
# COPY ./public/ /var/www/html/public/
COPY . /var/www/html

# Copy the nginx config file
COPY ./docker/nginx/nginx.conf /etc/nginx/conf.d/default.conf
