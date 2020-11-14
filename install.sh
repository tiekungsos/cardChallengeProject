echo "Start Install Project Card Challenge"

{
    {
       docker-compose up -d
    } && {
        docker exec docker-lemp_app_1 bash install-product.sh
    }

    echo "Success Install Project Card Challenge"
    echo "You can run web site this here : http://127.0.0.1:8081"

} || {
   echo "Installation error Please try again."
}


