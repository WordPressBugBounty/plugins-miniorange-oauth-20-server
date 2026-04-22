<?php
/**
 * Class MO_OAuth_Server_Keys
 *
 * @package Miniorange_Oauth_20_Server
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class MO_OAuth_Server_Keys
 *
 * This class stores the public and private keys used for JWT signing.
 */
class MO_OAuth_Server_Keys {

	/**
	 * Private key for JWT signing.
	 *
	 * @var string
	 */
	public static $private_key = "-----BEGIN RSA PRIVATE KEY-----\n" .
		"MIIJKQIBAAKCAgEA4TVk77HWIUc5KdUQXufr2eXuKMN6PfScl+KjxDF/41xdyXu/\n" .
		"KG+dxIzz3jp/dZCdGHEHWQQx4LT1fNTwSp5h33tKNn5gaL/UspjMC468Hj9uDYN+\n" .
		"XPhkNTqGQLmzRijAwH+Sqm4sM3GWwvlKm44QBEIXTgRaKripEFu70imV6CFKX4fm\n" .
		"FqD2O1bhXg6LNpZX8lOLKwUBS6VMmNQTnxFlyRapiCcTQbvZPHG6LO7KiRcqPcm6\n" .
		"qZFf2p+ogSEGOw71hcU7bW9ZLK6wMF/g03Azj+eWgcxGGIDUxlrv4hCXuFuzJEJ5\n" .
		"sBbjjRsZ815ri9xSYAF3njgvuETbHA59/nvzfl8EPI2DYQsAIYTxnd00ZWXAcbRA\n" .
		"EgxRsx1eJIFQMxp7Qg+jLr0n0OLQ29uGNiwK8NNJZbkEdm4ORfULIBVx3a5Bm1ad\n" .
		"zTORUIe3a+xVdLBlRyurRB28DaTJBbTPEE4wCLnjtoSvnTvX0EZFozIrjYm3uVUl\n" .
		"CDVY9DQT54mfRGrpuflvDK909+qlnTKedNcdoBzsh07QneFiZF0kQ5YOivz4GF1K\n" .
		"6QFYHBOWpLQ2mYRzJkwMgaJGDlBrZvTup0iWnRCwQHPajYKQ6YiCEQ9gaelEDoG9\n" .
		"v0ijzCGmKI5UJ9CNegcTrojiVLrGKg3M0cebtsPraAZdREqAXzLY3LUdQ3ECAwEA\n" .
		"AQKCAgEAi6StEselq/ra4iqAPSj3oKQnGdWj7djIZJGe1F+RGizC5tU5gdw76o0w\n" .
		"BgMl14M1NduYH8UvHFN4yM/Ms6gjrgxnxwRzyV/xhlCibSQzV1ojZnO7nfBTSoIg\n" .
		"ju/WztEkO/ieu9kWxUtQnVMwxOXA3rMQekrOkiDwi/klrDom/sntsPC2Zh+mrsK/\n" .
		"ea/w+Icev164M5Ol6v7zUOxnwkFqaNcJhigck6zkFcu7EnN62Kipg6ibettuoURQ\n" .
		"mskccPBko27Z25CorcEf9M7uvIydHEUQmSlN6ZGw3dGzXuzE9wa9POWPSPXYYT2F\n" .
		"yNcqPo398hPW1R+nz026w1nlHDBFmVL2TsVCPz5vGxQ47YRoQ92Z4JnqxcnOADqX\n" .
		"mth8o9iiUDwk0ZRtKCuF1i8n82i7Pl1vR6wHnaRii8QyvfhauDdSJ70lNA/O/wm5\n" .
		"S8+dctFLVLPDGfWa5k1BO5iB06j652IH2WEL/dDZNuaa/gEPMReyong5hpIBp/Dw\n" .
		"KltNGx5+ogDLcpVcrtwQZwbzgfznoY14n9zikZQ4L4jbRNCFxOhHYuiIyXkgfpg7\n" .
		"ouNXQma1vdLw9rLB3e92SS7Zirk8a8cn491MlxcmP8l2OWH8t4CQrHEpHJu3tO0o\n" .
		"9X6Ay7iKxSm3SjbG4IBzNA5FJ7Km/FZH5mFJMmxxN3PPGIMYxiUCggEBAP/xXbE0\n" .
		"E6bSd+OC4K4GduohxSRbMEnukKkTuKknRL63IhQZ0bgtCaVvRX5guPbasgZgAa9z\n" .
		"6KMOSnmXQAoCULekW4tiPKLDbARhiSHSUASI7SsxiYbALGt+xrPSFhUal45FI4AU\n" .
		"4fyqQ8sI0OiLC1mmu6nLYgqW+NgkOfZQc4BWPdNtOoz17VPabtZXj6RrpFjT13Xt\n" .
		"e/yKnl15LNIs3PpooS8vSkxul1zyK/lPVLXVevxomyz1xL4H/SpRfZYOvd9wU6xF\n" .
		"vwp4YuM4enRjtF+yPUyvSa2uEYfw0ke0o9f2iK5cndLkOb15hlCxeyx+l09Ebo9f\n" .
		"69BJvW3TX5btFrsCggEBAOFCRWDCqKm+VnkIXvH/kg4LexeOJlccgjl6W+sP6bhd\n" .
		"M52juRM5jp7LBuOEiPpB1VonFtH8sjr05Nr76mgzUNn/sAVPTOAiwBCaiVLXiymT\n" .
		"gIruWaovq4Y8ulpqbutfqZ9JTjnluUHROoLZKB006/QofNXkVnkGBMrUK/m7PlTl\n" .
		"t8J2i5EkYZ1H24E/Ek0WRX2Qap3pycm3yqDylga5SJKBlg/G4GtOlGBMMYZlB+bp\n" .
		"sLl55XCA31g3OSaagdGUuR0OFon66/21t0ZR2r3MbOGk78sRNR91gexN3FYeVTmu\n" .
		"XEsJIBTqYrwC6UpbWXrS1+vQwY3ShBRpsqCcteITKcMCggEAN3+cJGe5dyweSRxB\n" .
		"IhtOv9hQymBnqTBs9+zJ1wwn0P8fCaLLohdKBzCIri3FDepAPjelRelpYaogphsR\n" .
		"DNqRrDCclS3ZHiYoDw8jUE0tgr46R2p3etvDBhA4gBenKC5a/MOrPgPJOSOmjak8\n" .
		"u6Ai9u67tMbgXJF+Jkg8tVeepA6PW4BM+PH+43bzH9Fe2XVp7sUI7I5xm0Jnsrcq\n" .
		"6+xEgpwbj4K+prI4ajQtKuNz5/YBtCfutiIY5mgPEpUXGWna7E+MJUf+dAPE1aaS\n" .
		"jxhrrXCV8EH2RQ4AySyEPH5EJPlVjBGTO363solegbLqlaxhnROmsbpIBSNoSx9R\n" .
		"lAWXLwKCAQEAoSnSC3WaSL/2jGfRzmCk9cl/Cw5YHhE2lrsVkqty88YzDME7xCZ1\n" .
		"BOWLizKi8jIx3GuFJz4dopLePlLolh7I5P/LxzDCdsZGFlsKjyvJ1DhFSqFXo6yx\n" .
		"krxWNCRcMaji6iT/g+r5Tb7NlxqZWbQocSqajkntGG+W9CszP1yZLxKgE9DO8ExQ\n" .
		"TsA/q0wd4uthUoIF1e+TwO/vWJHXhv3/j1qJq8YFgKDbBb7d3CLisXJXT4yH/KMn\n" .
		"qKzyBc2bvgAjJUeUFqphN8dQVk5wK0VcTWC9c9Ne56AiEZhvYWoYXcmDHOhtfKlp\n" .
		"dMy8bsfG0FqTw5M7OCX6+8PX2pPkidheEwKCAQBVo4HxuVvgSCHiNuCtH5ZIWpQa\n" .
		"mWqYae+FSKe1ifO67HTV4v6j/rQ8y2mtWIhhyfTPW+rxZiTuPyL+r+Nmo7t1Jt4w\n" .
		"HA1/4SOfI/8emwWQYD1T3SCouSa0rzoOPN7KT8l9qBGhAOC7u5j3DNMK+nxVT9fr\n" .
		"3dkGiHURLFTCa/9wzJI1oVa7ttE8WLnWbLZPRDEYrB80HoWBXUmVxrs/JieE90LW\n" .
		"/wZ/BZ4eyS95JV/irfw38ewUq1EPelTbhOOdqSood1s7wwockLdPavpSjlvJCdhT\n" .
		"cA7/EdDA1a5ARtAe14963aKEJAozxE4neD1BX5a5qP+vbCBpAgxWr77Jwy7N\n" .
		'-----END RSA PRIVATE KEY-----';

	/**
	 * Public key for JWT signing.
	 *
	 * @var string
	 */
	public static $public_key = "-----BEGIN PUBLIC KEY-----\n" .
		"MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEA4TVk77HWIUc5KdUQXufr\n" .
		"2eXuKMN6PfScl+KjxDF/41xdyXu/KG+dxIzz3jp/dZCdGHEHWQQx4LT1fNTwSp5h\n" .
		"33tKNn5gaL/UspjMC468Hj9uDYN+XPhkNTqGQLmzRijAwH+Sqm4sM3GWwvlKm44Q\n" .
		"BEIXTgRaKripEFu70imV6CFKX4fmFqD2O1bhXg6LNpZX8lOLKwUBS6VMmNQTnxFl\n" .
		"yRapiCcTQbvZPHG6LO7KiRcqPcm6qZFf2p+ogSEGOw71hcU7bW9ZLK6wMF/g03Az\n" .
		"j+eWgcxGGIDUxlrv4hCXuFuzJEJ5sBbjjRsZ815ri9xSYAF3njgvuETbHA59/nvz\n" .
		"fl8EPI2DYQsAIYTxnd00ZWXAcbRAEgxRsx1eJIFQMxp7Qg+jLr0n0OLQ29uGNiwK\n" .
		"8NNJZbkEdm4ORfULIBVx3a5Bm1adzTORUIe3a+xVdLBlRyurRB28DaTJBbTPEE4w\n" .
		"CLnjtoSvnTvX0EZFozIrjYm3uVUlCDVY9DQT54mfRGrpuflvDK909+qlnTKedNcd\n" .
		"oBzsh07QneFiZF0kQ5YOivz4GF1K6QFYHBOWpLQ2mYRzJkwMgaJGDlBrZvTup0iW\n" .
		"nRCwQHPajYKQ6YiCEQ9gaelEDoG9v0ijzCGmKI5UJ9CNegcTrojiVLrGKg3M0ceb\n" .
		"tsPraAZdREqAXzLY3LUdQ3ECAwEAAQ==\n" .
		'-----END PUBLIC KEY-----';
}
