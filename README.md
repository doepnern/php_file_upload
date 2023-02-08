# php_file_upload
Aufgrund der wechselnden Aufgabe bin ich noch nicht weiter gekommen, aktuell werden nur die Dateien auf dem Server in einem Ordner gespeichert. Hier wäre es sicherlich sinnvoll die Metadaten in einer strukturierten Datenbank separat von den Dateien zu speichern um einen schnellen Zugriff auf diese zu ermöglichen. Bei großen Datenmengen könnte auch einee Blob storage, wie AWS S3 zum lagern der Dateien verwendet werden. Die Kommentare werden den passenden Dateien zugeordnet und in der JSON response zurückgegeben. Ich bin noch nicht dazu gekommen die einzelnen Files gemäß der JSON response nach erfolgreich und nicht erfolgreich zu sortieren und auch für upload progress hatte ich keine Zeit. 

## Start instruktionen:
### Docker:
- docker-compose up 
- dev server sollte auf localhost:80 laufen

### Manuell:
- inhalt von server/src/ in server root (z.b. apache) kopieren
- apache php ini anpassen 
- uploads ordner erstellen in (/var/www/uploads/)

