<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2017, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2017, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');


$lang['upload_userfile_not_set'] = 'No se pudo encontrar la variable POST llamada en el archivo de usuario';
$lang['upload_file_exceeds_limit'] = 'El archivo subido excede el tamaño máximo permitido en la configuración de PHP';
$lang['upload_file_exceeds_form_limit'] = 'El archivo subido excede el tamaño máximo permitido por el formulario';
$lang['upload_file_partial'] = 'El archivo fue sólo subido parcialmente.';
$lang['upload_no_temp_directory'] = 'No se encuentra la Carpeta Temporal de subida.';
$lang['upload_unable_to_write_file'] = 'El archivo no puede ser escrito en disco';
$lang['upload_stopped_by_extension'] = 'La subida de archivo fue detenida por extensión.';
$lang['upload_no_file_selected'] = 'No seleccionaste un archivo de subida.';
$lang['upload_invalid_filetype'] = 'El tipo de archivo que estás intentando subir, no está permitido.';
$lang['upload_invalid_filesize'] = 'El tamaño de archivo que estás intentando subir, es más grande que el permitido';
$lang['upload_invalid_dimensions'] = 'La imagen que estás intentando subir no tiene las dimensiones permitidas';
$lang['upload_destination_error'] = 'Un problema fue encontrado mientras se intentaba mover el archivo de subida al destino final.';
$lang['upload_no_filepath'] = 'La ruta de subida parece ser no válida.';	
$lang['upload_no_file_types'] = 'No has especificado ningún tipo de archivo permitido';
$lang['upload_bad_filename'] = 'El archivo que has subido ya existe en el servidor.';
$lang['upload_not_writable'] = 'La carpeta de destino de subida parece no tener permisos de escritura';