Important facts about the safety of web projects on CMS H-SCRIPT






Even a well-written code can be a subject to vulnerabilities if the web project is located on the unsafely configured hosting.
The consequence of unsafe configured web server may be hacking and the subsequent capture of the site by attackers.
In this regard, placing of the site on a safe hosting is particularly important.
The following recommendations are based on best security practices and experience of our specialists in protection of projects made on H-SCRIPT from hacking:
Protected from hacking hosting must possess a number of attributes, among which, first of all, can be:
*Protection from OWASP Top 10 Application Secuirty Risks, including SQL Injection, XSS, PHP-Including etc.
*Secure network connections (restriction of incoming/outgoing connections through iptables)
*Security level for users and groups
*Security of permissions for the file system objects
*Safe execution of php-code
*Sending of e-mail notifications about possible security incidents.
On the server must be deployed WAF (Web Application Firewall), ie mod_security, that will significantly reduce the likelihood of a successful hacking of web server.
Also it is necessary to reconfigure PHP, and system environment for the safe execution of code (disabling of potentially dangerous functions, prevention of RFI execution (Remote File Inclusion), execution of web shells, setting of adequate rights to files and directories in system environment).
To prevent launch of not-PHP web shells — possibility of execution of perl, python, ruby etc. scripts on behalf of the web server is highly desirable to disable.
To prevent possible compilation of exploits and launch of bind/back connect backdoors — GCC and NC must have the appropriate permissions (ie 750 or 700).
If you do not know how to do all of the above, I advise you to hire system administratoror (check here https://www.fl.ru/freelancers/sistemnyj-administrator/) better expert on data protection  (check here https://www.fl.ru/freelancers/specialist-zaschita-informacii/)
which will keep track of your project.
The main recommendations, which must adhere every site administrator:
1. Open 2 wallets for each payment system, one API, the second SCI;
2. Do not keep large amounts on API wallet;
3. Do not pass access to the site to unauthorized users;
4. Change passwords, no matter how much confidence you have in the developers;
5. Create a passphrase of at least 16 characters/digits in length for Perfect Money;
6. Buy an expensive and high-quality hosting (evade Koddos, Geniusguard);
Before the start of the project, you should be aware of and be prepared for all kinds of risks, including the risk of hacking. Unfortunately, sometimes hack even such giants as SONY or Microsoft, and 100% protection no one can give. However, if you follow the recommendations outlined above, you will reduce the risk of hacking to the minimum possible.
None of our competitors does not give such recommendations or even raises such a problem. Our own approach is different: we care about our customers and try to make the work with HS convenient and safe!