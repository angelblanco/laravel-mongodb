#!/usr/bin/env bash
set -e

SCRIPTPATH="$( cd "$(dirname "$0")" >/dev/null 2>&1 ; pwd -P )"

cd "$SCRIPTPATH"

function local-docker-compose() {
    docker-compose -f docker-compose.yml -f docker-compose.local.yml "$@"
}

# Banner
R_COMMAND="echo ''"
R_COMMAND="$R_COMMAND && echo '██╗      █████╗ ██████╗  █████╗ ██╗   ██╗███████╗██╗            '"
R_COMMAND="$R_COMMAND && echo '██║     ██╔══██╗██╔══██╗██╔══██╗██║   ██║██╔════╝██║            '"
R_COMMAND="$R_COMMAND && echo '██║     ███████║██████╔╝███████║██║   ██║█████╗  ██║            '"
R_COMMAND="$R_COMMAND && echo '██║     ██╔══██║██╔══██╗██╔══██║╚██╗ ██╔╝██╔══╝  ██║            '"
R_COMMAND="$R_COMMAND && echo '███████╗██║  ██║██║  ██║██║  ██║ ╚████╔╝ ███████╗███████╗       '"
R_COMMAND="$R_COMMAND && echo '╚══════╝╚═╝  ╚═╝╚═╝  ╚═╝╚═╝  ╚═╝  ╚═══╝  ╚══════╝╚══════╝       '"
R_COMMAND="$R_COMMAND && echo '                                                                '"
R_COMMAND="$R_COMMAND && echo '███╗   ███╗ ██████╗ ███╗   ██╗ ██████╗  ██████╗ ██████╗ ██████╗ '"
R_COMMAND="$R_COMMAND && echo '████╗ ████║██╔═══██╗████╗  ██║██╔════╝ ██╔═══██╗██╔══██╗██╔══██╗'"
R_COMMAND="$R_COMMAND && echo '██╔████╔██║██║   ██║██╔██╗ ██║██║  ███╗██║   ██║██║  ██║██████╔╝'"
R_COMMAND="$R_COMMAND && echo '██║╚██╔╝██║██║   ██║██║╚██╗██║██║   ██║██║   ██║██║  ██║██╔══██╗'"
R_COMMAND="$R_COMMAND && echo '██║ ╚═╝ ██║╚██████╔╝██║ ╚████║╚██████╔╝╚██████╔╝██████╔╝██████╔╝'"
R_COMMAND="$R_COMMAND && echo '╚═╝     ╚═╝ ╚═════╝ ╚═╝  ╚═══╝ ╚═════╝  ╚═════╝ ╚═════╝ ╚═════╝ '"
R_COMMAND="$R_COMMAND && echo ''"

# Versions
R_COMMAND="$R_COMMAND && php --version && echo '' "
R_COMMAND="$R_COMMAND && composer --version && echo '' "

# Help
R_COMMAND="$R_COMMAND && echo 'The code is updated from your filesystem'"
R_COMMAND="$R_COMMAND && echo ' - Run all tests with: composer test'"
R_COMMAND="$R_COMMAND && echo ' - Run tests alternatively with: vendor/bin/phpunit'"
R_COMMAND="$R_COMMAND && echo ' - Update packages with composer update'"
R_COMMAND="$R_COMMAND && echo ''"

docker-compose down
local-docker-compose build
local-docker-compose run --rm php bash -c "$R_COMMAND && bash"
