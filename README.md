Enable Uploads via apache:
	sudo chown apache:apache -R upload
	sudo chcon -Rv --type=httpd_sys_rw_content_t upload/

Error: SQLSTATE[HY000] [2002] Permission denied:
https://stackoverflow.com/questions/34673627/sqlstatehy000-2002-permission-denied
This happens because selinux avoids db connections from the httpd server to the remote db server. To solve it you need to access your server through ssh or just open a console if you have pretencial access and do the following:

You must check in the SELinux if port 80 is managed in. You can check it by typing # semanage port -l | grep http_port_t for a list and check:

http_port_t tcp 443, 488, 8008, 8009, 8443, 9000

If you need to add the required port, just type:

# semanage port -a -t http_port_t -p tcp 80

Type the command to check once again:

# semanage port -l | grep http_port_t

http_port_t tcp 80, 443, 488, 8008, 8009, 8443, 9000

Then you should notify SELinux you want to allow network connections from the httpd server to the db remote server, setting the boolean variables that set it:

Down the httpd service # service httpd stop
# setsebool httpd_can_network_connect 1
# setsebool httpd_can_network_connect_db 1
Up the httpd service # service httpd start
Now your httpd service should be capable to get data from the db server.

These changes wont remain after a reboot. To make them permanent, instead do the following:

Down the httpd service # service httpd stop
# setsebool -P httpd_can_network_connect 1
# setsebool -P httpd_can_network_connect_db 1
Up the httpd service # service httpd start
The difference is the "-P" flag.

I hope that can be useful for the gang that searches solve errors like this.

