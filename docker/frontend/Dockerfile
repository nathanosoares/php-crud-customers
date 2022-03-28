FROM node:16-alpine

RUN apk update --no-cache \
    && apk add \
    curl

WORKDIR  /frontend

COPY docker-entrypoint.sh /
RUN chmod +x /docker-entrypoint.sh

ENTRYPOINT ["/docker-entrypoint.sh"]

CMD ["npm", "start"]