ARCHIVENAME = frisbee-payment-gateway.zip

build:
	zip -r "$(ARCHIVENAME)" ./components/ update.php README.md
