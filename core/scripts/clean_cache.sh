dir="$( dirname "$0" )"
dir="$dir/../.."
echo "Repertoire traité : $dir"


echo "" > /tmp/clean_cache

echo "rm -rf $dir/app/cache/*" >> /tmp/clean_cache

if [ "$1" = "go" ]; then
	cat /tmp/clean_cache
	. /tmp/clean_cache
    rm /tmp/clean_cache
else
    echo ""
    echo "Ces commandes seront executés :"
	cat /tmp/clean_cache
	echo ""
	echo "Ajoutez le parametre 'go' pour lancer la suppresion"
fi
