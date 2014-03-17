all: archive

archive:
	tar -zcvf gimmie.tgz \
		Sources/Subs-GimmieRewards.php \
		Sources/Gimmie/Gimmie_OAuth.php \
		Sources/Gimmie/Gimmie.sdk.php \
		Themes/GimmieRewards.admin.template.php \
		Themes/languages \
		Themes/css/GimmieRewards.css \
		install.php \
		readme.txt \
		uninstall.php \
		package-info.xml
