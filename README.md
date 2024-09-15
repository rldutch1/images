Enable Uploads via apache:
	<span style="color: #3366ff;">sudo chown apache:apache -R upload</span>
	<span style="color: #3366ff;">sudo chcon -Rv --type=httpd_sys_rw_content_t upload/</span>

Convert file1 to file2:
	<span style="color: #3366ff;">ffmpeg -i $1 -vcodec copy -acodec copy $2</span>

Error: SQLSTATE[HY000] [2002] Permission denied:
	<span style="color: #3366ff;">https://stackoverflow.com/questions/34673627/sqlstatehy000-2002-permission-denied<br /.>
This happens because selinux avoids db connections from the httpd server to the remote db server. To solve it you need to access your server through ssh or just open a console if you have pretencial access and do the following:
	</span>
You must check in the SELinux if port 80 is managed. You can check it by typing #: <br />
	<span style="color: #3366ff;">semanage port -l | grep http_port_t  <br />
	for a list and check: <br />
	http_port_t tcp 443, 488, 8008, 8009, 8443, 9000 <br />
	</span>

If you need to add the required port, just type:
	<span style="color: #3366ff;">semanage port -a -t http_port_t -p tcp 80</span>

Type the command to check once again:
	<span style="color: #3366ff;">semanage port -l | grep http_port_t <br />
	http_port_t tcp 80, 443, 488, 8008, 8009, 8443, 9000 <br />
	</span>

Then you should notify SELinux you want to allow network connections from the httpd server to the db remote server, setting the boolean variables that set it:

Down the httpd service # service httpd stop
	<span style="color: #3366ff;">setsebool httpd_can_network_connect 1</span>
	<span style="color: #3366ff;">setsebool httpd_can_network_connect_db 1</span>

Up the httpd service # 
	<span style="color: #3366ff;">service httpd start</span>
Now your httpd service should be capable to get data from the db server.

These changes wont remain after a reboot. To make them permanent, instead do the following:
Down the httpd service # service httpd stop
	<span style="color: #3366ff;">setsebool -P httpd_can_network_connect 1</span>
	<span style="color: #3366ff;">setsebool -P httpd_can_network_connect_db 1</span>

Up the httpd service:
	<span style="color: #3366ff;">service httpd start</span>
The difference is the "-P" flag.


