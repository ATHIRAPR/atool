FROM php:5.6-apache

RUN sed -i 's|http://deb.debian.org/debian|http://archive.debian.org/debian|g' /etc/apt/sources.list && \
    sed -i 's|http://security.debian.org/debian-security|http://archive.debian.org/debian-security|g' /etc/apt/sources.list && \
        sed -i '/stretch-updates/d' /etc/apt/sources.list && \
            echo 'Acquire::Check-Valid-Until "false";' > /etc/apt/apt.conf.d/99fix-archive && \
                echo 'Acquire::AllowInsecureRepositories "true";' >> /etc/apt/apt.conf.d/99fix-archive && \
                    echo 'APT::Get::AllowUnauthenticated "true";' >> /etc/apt/apt.conf.d/99fix-archive && \
                        echo 'Acquire::http::No-Cache "true";' >> /etc/apt/apt.conf.d/99fix-archive && \
                            apt-get clean && rm -rf /var/lib/apt/lists/* && apt-get update

                            # Install required packages for FreeTDS and PHP extensions
                            RUN apt-get install -y --allow-unauthenticated \
                                freetds-dev \
                                    libsybdb5 \
                                        libpng-dev \
                                            libjpeg-dev \
                                                libxml2-dev \
                                                    libmcrypt-dev \
                                                        zip \
                                                            unzip \
                                                                git \
                                                                    curl \
                                                                        locales \
                                                                            gnupg \
                                                                                apt-transport-https

                                                                                # Create symlink for libsybdb.so to satisfy pdo_dblib installer
                                                                                RUN ln -s /usr/lib/x86_64-linux-gnu/libsybdb.so /usr/lib/libsybdb.so

                                                                                # Install PHP extensions
                                                                                RUN docker-php-ext-install \
                                                                                    pdo \
                                                                                        pdo_mysql \
                                                                                            mbstring \
                                                                                                xml \
                                                                                                    zip \
                                                                                                        mcrypt \
                                                                                                            pdo_dblib


                                                                                                            # Enable Apache mod_rewrite
                                                                                                            RUN a2enmod rewrite

                                                                                                            # Set working directory
                                                                                                            WORKDIR /var/www/html

                                                                                                            # Copy project files
                                                                                                            # COPY . /var/www/html/

                                                                                                            # Set permissions
                                                                                                            RUN chown -R www-data:www-data /var/www/html \
                                                                                                                && chmod -R 755 /var/www/html

                                                                                                                # Apache configuration
                                                                                                                COPY webserver/apache2.conf /etc/apache2/apache2.conf
                                                                                                                COPY webserver/vhost.conf /etc/apache2/sites-available/000-default.conf

                                                                                                                EXPOSE 80

                                                                                                                CMD ["apache2-foreground"]