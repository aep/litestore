/*
  +----------------------------------------------------------------------+
  | PHP Version 5                                                        |
  +----------------------------------------------------------------------+
  | Copyright (c) 1997-2009 The PHP Group                                |
  +----------------------------------------------------------------------+
  | This source file is subject to version 3.01 of the PHP license,      |
  | that is bundled with this package in the file LICENSE, and is        |
  | available through the world-wide-web at the following url:           |
  | http://www.php.net/license/3_01.txt                                  |
  | If you did not receive a copy of the PHP license and are unable to   |
  | obtain it through the world-wide-web, please send a note to          |
  | license@php.net so we can mail you a copy immediately.               |
  +----------------------------------------------------------------------+
  | Authors: Michael Wallner <mike@php.net>                              |
  |          Sara Golemon <pollita@php.net>                              |
  +----------------------------------------------------------------------+
*/

/* $Id: hash_adler32.c,v 1.3.2.4.2.4 2008/12/31 11:17:38 sebastian Exp $ */

#include "php_hash.h"
#include "php_hash_adler32.h"

PHP_HASH_API void PHP_ADLER32Init(PHP_ADLER32_CTX *context)
{
	context->state = 1;
}

PHP_HASH_API void PHP_ADLER32Update(PHP_ADLER32_CTX *context, const unsigned char *input, size_t len)
{
	php_hash_uint32 i, s[2];
	
	s[0] = context->state & 0xffff;
	s[1] = (context->state >> 16) & 0xffff;
	for (i = 0; i < len; ++i) {
		s[0] = (s[0] + input[i]) % 65521;
		s[1] = (s[1] + s[0]) % 65521;
	}
	context->state = s[0] + (s[1] << 16);
}

PHP_HASH_API void PHP_ADLER32Final(unsigned char digest[4], PHP_ADLER32_CTX *context)
{
	digest[3] = (unsigned char) ((context->state >> 24) & 0xff);
	digest[2] = (unsigned char) ((context->state >> 16) & 0xff);
	digest[1] = (unsigned char) ((context->state >> 8) & 0xff);
	digest[0] = (unsigned char) (context->state & 0xff);
	context->state = 0;
}

const php_hash_ops php_hash_adler32_ops = {
	(php_hash_init_func_t) PHP_ADLER32Init,
	(php_hash_update_func_t) PHP_ADLER32Update,
	(php_hash_final_func_t) PHP_ADLER32Final,
	4, /* what to say here? */
	4,
	sizeof(PHP_ADLER32_CTX)
};

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 * vim600: sw=4 ts=4 fdm=marker
 * vim<600: sw=4 ts=4
 */