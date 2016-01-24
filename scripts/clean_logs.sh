# Néttoie le repertoire en supprimant les fichier de cache/logs/tmp trop vieux

dir="$( dirname "$0" )"
dir="$dir/.."
echo "Repertoire traité : $dir"

if [ "$1" = "all" ]; then
	timed="0"
else
	timed="+14"
fi

echo "" > /tmp/clean_logs

find $dir/app/logs -type f -name "*.log" -mtime $timed -exec echo "rm -f {}" >> /tmp/clean_logs \;

if [ "$1" = "go" ] || [ "$2" = "go" ]; then
	cat /tmp/clean_logs
	. /tmp/clean_logs
    rm /tmp/clean_logs
else
    echo ""
    echo "Ces commandes seront executés :"
	cat /tmp/clean_logs
	echo ""
	echo "Ajoutez le parametre 'go' pour lancer la suppresion"
fi
