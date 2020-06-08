FROM postgres:11

RUN apt-get update --fix-missing && apt-get install -y \
		locales \
			&& echo "ru_RU.UTF-8 UTF-8" >> /etc/locale.gen \
			&& echo "en_US.UTF-8 UTF-8" >> /etc/locale.gen \
			&& echo "en_GB.UTF-8 UTF-8" >> /etc/locale.gen \
			&& echo "eu_FR.UTF-8 UTF-8" >> /etc/locale.gen \
			&& echo "it_IT.UTF-8 UTF-8" >> /etc/locale.gen \
			&& echo "de_DE.UTF-8 UTF-8" >> /etc/locale.gen \
			&& echo "ru_UA.UTF-8 UTF-8" >> /etc/locale.gen \
			&& locale-gen
RUN localedef -i ru_RU -c -f UTF-8 -A /usr/share/locale/locale.alias ru_RU.UTF-8

ENV TZ Europe/Moscow
ENV LANG ru_RU.UTF-8
ENV LANGUAGE ru_RU.UTF-8
ENV LC_ALL ru_RU.UTF-8
