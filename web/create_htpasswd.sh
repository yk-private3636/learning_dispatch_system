user_name="test"
pass="test"
cryptpass=`openssl passwd -crypt ${pass}`

echo "${user_name}:${cryptpass}" > /etc/apache2/.htpasswd