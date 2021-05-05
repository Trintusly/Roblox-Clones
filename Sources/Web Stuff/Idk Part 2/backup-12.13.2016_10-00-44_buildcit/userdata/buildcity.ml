--- 
customlog: 
  - 
    format: combined
    target: /usr/local/apache/domlogs/buildcity.ml
  - 
    format: "\"%{%s}t %I .\\n%{%s}t %O .\""
    target: /usr/local/apache/domlogs/buildcity.ml-bytes_log
documentroot: /home/buildcit/public_html
group: buildcit
hascgi: 1
homedir: /home/buildcit
ip: 162.144.152.200
owner: root
phpopenbasedirprotect: 1
port: 80
scriptalias: 
  - 
    path: /home/buildcit/public_html/cgi-bin
    url: /cgi-bin/
serveradmin: webmaster@buildcity.ml
serveralias: mail.buildcity.ml www.buildcity.ml
servername: buildcity.ml
usecanonicalname: 'Off'
user: buildcit
