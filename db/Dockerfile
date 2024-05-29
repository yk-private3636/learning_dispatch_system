FROM mysql:8-debian
RUN rm /etc/apt/sources.list.d/mysql.list
RUN apt-get update
RUN apt-get -y install locales-all
ENV LANG ja_JP.UTF-8
ENV LANGUAGE ja_JP:ja
ENV LC_ALL ja_JP.UTF-8
RUN chmod -R +x /docker-entrypoint-initdb.d/
COPY ./my.cnf /etc/mysql/my.cnf
