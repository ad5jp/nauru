<?php
const THEME_NAMESPACE = 'Nauru\\';

spl_autoload_register( 'agi_autoload' );

function agi_autoload( $class_name )
{

	if ( 0 !== strpos( $class_name, THEME_NAMESPACE ) ) {
		return;
	}

	$class_name = str_replace( THEME_NAMESPACE, '', $class_name );
	$class_paths = explode( '\\', $class_name );
	$class_basename = array_pop( $class_paths );
	$classfile_basename = 'class-'. strtolower( str_replace( '_', '-', $class_basename ) ) . '.php';
	$classfile_path = TEMPLATEPATH . DIRECTORY_SEPARATOR
					. 'includes' . DIRECTORY_SEPARATOR
					. join( DIRECTORY_SEPARATOR, array_map( 'strtolower', $class_paths ) ) . DIRECTORY_SEPARATOR
					. $classfile_basename;

	if ( file_exists( $classfile_path ) ) {
		include( $classfile_path );
	}
}
