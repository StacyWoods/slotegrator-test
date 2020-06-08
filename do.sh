#!/usr/bin/env sh
is_in_docker() {
  if [ -f /.dockerenv ]; then
      echo "I'm inside matrix";
  else
      echo "I'm living in real world";
  fi
}

retval=$( is_in_docker )
if [ "$retval" == "I'm inside matrix" ]
then
  command_env="";
else
  command_env="docker exec -it slotegrator-php ";
fi

${command_env} $1;
