FROM ubuntu:16.04

MAINTAINER Salvatore Cordiano <docker@parallel.it>

ENV DEBIAN_FRONTEND noninteractive

RUN apt-get update && apt-get install -y curl git vim zip php7.0 php7.0-curl php7.0-gd php7.0-mysql php7.0-json php7.0-opcache php7.0-xml php7.0-xmlrpc php7.0-fpm php7.0-mbstring php7.0-intl php7.0-mcrypt php7.0-xsl php7.0-zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Oh-My-Zsh
RUN apt-get install -y zsh
RUN git clone git://github.com/robbyrussell/oh-my-zsh.git ~/.oh-my-zsh \
      && cp ~/.oh-my-zsh/templates/zshrc.zsh-template ~/.zshrc \
      && chsh -s /bin/zsh

WORKDIR /home
