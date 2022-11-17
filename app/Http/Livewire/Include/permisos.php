<?php

	$ver = DB::table('permisos')
		->where('rol_id', Auth::user()->rol_id)
		->where('modulo_id', $mdl)
		->where('ver', '=', 1)
		->where('estado', 1)
		->count();
	
	$crear = DB::table('permisos')
		->where('rol_id', Auth::user()->rol_id)
		->where('modulo_id', $mdl)
		->where('crear', '=', 1)
		->where('estado', 1)
		->count();
	
	$editar = DB::table('permisos')
		->where('rol_id', Auth::user()->rol_id)
		->where('modulo_id', $mdl)
		->where('editar', '=', 1)
		->where('estado', 1)
		->count();
	
	$borrar = DB::table('permisos')
		->where('rol_id', Auth::user()->rol_id)
		->where('modulo_id', $mdl)
		->where('borrar', '=', 1)
		->where('estado', 1)
		->count();
	
	$exportar = DB::table('permisos')
		->where('rol_id', Auth::user()->rol_id)
		->where('modulo_id', $mdl)
		->where('exportar', '=', 1)
		->where('estado', 1)
		->count();
	
	$importar = DB::table('permisos')
		->where('rol_id', Auth::user()->rol_id)
		->where('modulo_id', $mdl)
		->where('importar', '=', 1)
		->where('estado', 1)
		->count();
