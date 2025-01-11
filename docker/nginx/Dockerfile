FROM nginx:latest

COPY templates/default.conf.template /etc/nginx/templates/default.conf.template
COPY templates/dev.conf /etc/nginx/templates/dev.conf

RUN envsubst < /etc/nginx/templates/default.conf.template > /etc/nginx/conf.d/default.conf

CMD ["nginx", "-g", "daemon off;"]