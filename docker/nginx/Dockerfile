FROM nginx:latest

COPY templates/* /etc/nginx/templates/

RUN envsubst < /etc/nginx/templates/default.conf.template > /etc/nginx/conf.d/default.conf

CMD ["nginx", "-g", "daemon off;"]