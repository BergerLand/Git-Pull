# Git-Pull
PHP script which pulls from GitHub web-hooks after code is pushed.

(c) 2017 Phillip R Berger - phillip@berger.land
http://www.berger.land

Free to use this under GNU General Public License v3.0
Attribute me where you can

This file checks the hash coming from GitHub and only pulls the code if that hash matches
based on the shared secret and other criteria that come from GitHub

Make sure you use the $sharedSecret and tell GitHub about it.  That keeps this whole thing secure!
