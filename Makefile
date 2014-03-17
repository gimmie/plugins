all: archive

archive:
	COPYFILE_DISABLE=1 tar zcvf gimmie.tgz \
		Sources/Subs-GimmieRewards.php \
		Sources/Gimmie/Gimmie_OAuth.php \
		Sources/Gimmie/Gimmie.sdk.php \
		Themes/GimmieRewards.admin.template.php \
		Themes/languages/GimmieRewards.english.php \
		Themes/css/GimmieRewards.css \
		install.php \
		readme.txt \
		uninstall.php \
		package-info.xml
