# image de départ : ubuntu la dernière
FROM debian:latest

ENV DEBIAN_FRONTEND="noninteractive"

# mise à jour de la liste des paquets et installation d'apache+php
RUN apt-get update && \
    apt-get -y install \
    vim nano less npm \
    node-node-sass \
    apache2 &&\
    apt-get clean && \
    rm -rf /var/cache/apt/archives /var/lib/apt/lists

# le port 80 est exposé ; 
EXPOSE 80

# container
CMD ["/usr/sbin/apache2ctl", "-DFOREGROUND" ]
