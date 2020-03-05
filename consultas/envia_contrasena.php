<?php
	include('../includes/conectar.php');
	
	$email = $_POST['email'];
	
	$verifica = "select estado, nombres, ape_pat, ape_mat, ruc_empresa, nick, contrasena from usuario where email = '".$email."'";
	$resultado = $conn->query($verifica); 
	if ($resultado->num_rows > 0) {
		while ($fila = $resultado->fetch_assoc()) {
			$estado = $fila['estado'];
			$nombres = ucwords(strtolower($fila['nombres']));
			$ape_pat = ucwords(strtolower($fila['ape_pat']));
			$ape_mat = ucwords(strtolower($fila['ape_mat']));
			$usuario  = $fila['nick'];
			$password  = $fila['contrasena'];
			$empresa  = $fila['ruc_empresa'];
			if ($estado == "1") {
				$email_message = '<!DOCTYPE html>
				<html lang="es"><head>
	<style type="text/css">
	</style>
</head>
<body>
	<div dir="ltr">
		<div class="gmail_quote">
			<div style="word-wrap:break-word">
				<div>
					<div>
						<div>
							<br>
							<div>
								<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#eeeeee" background="https://static2.mailerlite.com/images/builder/background/geometry.png" style="border-spacing:0px;border-collapse:collapse;font-family:Helvetica;letter-spacing:normal;text-indent:0px;text-transform:none;word-spacing:0px;background-color:rgb(238,238,238)">
									<tbody>
										<tr>
											<td align="center" style="border-collapse:collapse">
												<table width="640" cellspacing="0" cellpadding="0" border="0" align="center" style="border-spacing:0px;border-collapse:collapse">
													<tbody>
														<tr>
															<td height="30" width="640" style="border-collapse:collapse;min-width:640px"></td>
														</tr>
													</tbody>
												</table>
												<table align="center" width="640" cellpadding="0" cellspacing="0" border="0" style="border-spacing:0px;border-collapse:collapse;width:640px">
													<tbody>
														<tr>
															<td width="640" style="border-collapse:collapse;min-width:640px;width:640px">
																<table width="640" cellspacing="0" cellpadding="0" border="0" bgcolor="#2C3E50" align="center" style="border-spacing:0px;border-collapse:collapse;width:640px">
																	<tbody>
																		<tr>
																			<td align="left" style="border-collapse:collapse;padding:30px 50px;background-color:rgb(44,62,80);background-position:initial initial;background-repeat:initial initial">
																				<table width="100" cellspacing="0" cellpadding="0" border="0" align="left" style="border-spacing:0px;border-collapse:collapse;width:100px">
																					<tbody>
																						<tr>
																							<td width="100" height="100" style="border-collapse:collapse;width:100px;height:100px"><img border="0" src="https://static1.mailerlite.com/data/builder/486895/20150816100851566_100_100_1_0.jpeg" width="100" height="100" alt="" style="border:0px solid rgb(0,0,0);border-top-left-radius:50px;border-top-right-radius:50px;border-bottom-right-radius:50px;border-bottom-left-radius:50px;display:inline-block"></td>
																						</tr>
																					</tbody>
																				</table>
																				<table width="410" cellspacing="0" cellpadding="0" border="0" align="right" style="border-spacing:0px;border-collapse:collapse;width:410px">
																					<tbody>
																						<tr>
																							<td align="left" height="100" valign="middle" style="border-collapse:collapse">
																								<h1 style="margin:0px;font-family:Arial;font-size:31px;line-height:37px;color:rgb(255,255,255);font-weight:normal;text-align:left">Yaveh Transport!</h1>
																								<h2 style="margin:5px 0px 0px;font-family:Arial;font-size:20px;line-height:24px;color:rgb(189,195,199);font-weight:normal;text-align:left">Recordatorio de Contrasena!</h2>
																							</td>
																						</tr>
																					</tbody>
																				</table>
																			</td>
																		</tr>
																	</tbody>
																</table>
															</td>
														</tr>
													</tbody>
												</table>
												<table width="640" cellspacing="0" cellpadding="0" border="0" align="center" style="border-spacing:0px;border-collapse:collapse;background-color:rgb(255,255,255);width:640px;background-position:initial initial;background-repeat:initial initial">
													<tbody>
														<tr>
															<td height="15" width="640" style="border-collapse:collapse;min-width:640px;width:640px">
																<table width="640" cellspacing="0" cellpadding="0" border="0" align="center" style="border-spacing:0px;border-collapse:collapse;width:640px">
																	<tbody>
																		<tr>
																			<td height="15" width="640" style="border-collapse:collapse;min-width:640px;width:640px"></td>
																		</tr>
																	</tbody>
																</table>
															</td>
														</tr>
													</tbody>
												</table>
												<table align="center" width="640" cellpadding="0" cellspacing="0" border="0" style="border-spacing:0px;border-collapse:collapse">
													<tbody>
														<tr>
															<td style="border-collapse:collapse">
																<table width="640" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0" align="center" style="border-spacing:0px;border-collapse:collapse;width:640px">
																	<tbody>
																		<tr>
																			<td align="center" style="border-collapse:collapse;padding:5px 50px">
																				<h1 style="margin:0px;font-family:Arial;font-weight:bold;font-size:25px;text-decoration:none;line-height:44px">Datos del Usuario: '.$nombres. ' '.$ape_pat .' '.$ape_mat .'</h1>
																			</td>
																		</tr>
																	</tbody>
																</table>
															</td>
														</tr>
													</tbody>
												</table>
												<table align="center" width="640" cellpadding="0" cellspacing="0" border="0" style="border-spacing:0px;border-collapse:collapse">
													<tbody>
														<tr>
															<td style="border-collapse:collapse">
																<table width="640" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0" align="center" style="border-spacing:0px;border-collapse:collapse;width:640px">
																	<tbody>
																		<tr>
																			<td align="left" style="border-collapse:collapse;padding:15px 50px;font-family:Arial;font-size:13px;line-height:22px">
																				<p style="margin:0px 0px 10px;line-height:22px">Empresa: '.$empresa.'</p>
																				<p style="margin:0px 0px 10px;line-height:22px">Usuario: '.$usuario.'</p>
																				<p style="margin:0px 0px 10px;line-height:22px">Contrasena: '.$password.'</p>
																			</td>
																		</tr>
																	</tbody>
																</table>
															</td>
														</tr>
													</tbody>
												</table>
												<table align="center" width="640" cellpadding="0" cellspacing="0" border="0" style="border-spacing:0px;border-collapse:collapse">
													<tbody>
														<tr>
															<td style="border-collapse:collapse">
																<table width="640" cellspacing="0" cellpadding="0" border="0" bgcolor="#FFFFFF" align="center" style="border-spacing:0px;border-collapse:collapse;width:640px">
																	<tbody>
																		<tr>
																			<td width="540" style="border-collapse:collapse;padding:0px 0px 0px 50px">
																				<table width="540" cellspacing="0" cellpadding="0" border="0" align="left" style="border-spacing:0px;border-collapse:collapse;width:540px">
																					<tbody>
																						<tr>
																							<td style="border-collapse:collapse;padding:15px 0px"><a href="http://conmetal.pe/zeus_transport/" style="word-wrap:break-word;background-color:rgb(39,174,96);color:rgb(255,255,255);font-family:Arial;font-size:15px;min-height:45px;line-height:45px;border-top-left-radius:6px;border-top-right-radius:6px;border-bottom-right-radius:6px;border-bottom-left-radius:6px;text-align:center;text-decoration:none;font-weight:bold;display:block;margin:0px;width:540px" target="_blank">clic aqui para iniciar Sesion en Yaveh Transport</a></td>
																						</tr>
																					</tbody>
																				</table>
																			</td>
																		</tr>
																	</tbody>
																</table>
															</td>
														</tr>
													</tbody>
												</table>
												<table align="center" width="640" cellpadding="0" cellspacing="0" border="0" style="border-spacing:0px;border-collapse:collapse">
													<tbody>
														<tr>
															<td style="border-collapse:collapse">
																<table width="640" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0" align="center" style="border-spacing:0px;border-collapse:collapse;width:640px">
																	<tbody>
																		<tr>
																			<td align="left" style="border-collapse:collapse;padding:15px 50px;font-family:Arial;font-size:13px;line-height:22px">
																				<p style="margin:0px 0px 10px;line-height:22px">Por favor almacene estos datos en un lugar seguro, evite que otras personas ingresen sin autorizacion suya.</p>
																			</td>
																		</tr>
																	</tbody>
																</table>
															</td>
														</tr>
													</tbody>
												</table>
												<table align="center" width="640" cellpadding="0" cellspacing="0" border="0" style="border-spacing:0px;border-collapse:collapse">
													<tbody>
														<tr>
															<td style="border-collapse:collapse">
																<table width="640" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0" align="center" style="border-spacing:0px;border-collapse:collapse;width:640px">
																	<tbody>
																		<tr>
																			<td align="left" style="border-collapse:collapse;padding:15px 50px;font-family:Arial;font-size:13px;line-height:22px">
																				<p style="margin:0px 0px 10px;line-height:22px">Imprima solo si es necesario, por un Peru mejor.</p>
																			</td>
																		</tr>
																	</tbody>
																</table>
															</td>
														</tr>
													</tbody>
												</table>
												<table align="center" width="640" cellpadding="0" cellspacing="0" border="0" style="border-spacing:0px;border-collapse:collapse">
													<tbody>
														<tr>
															<td style="border-collapse:collapse">
																<table width="640" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0" align="center" style="border-spacing:0px;border-collapse:collapse;width:640px">
																	<tbody>
																		<tr>
																			<td style="border-collapse:collapse;padding:15px 50px 0px">
																				<table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-spacing:0px;border-collapse:collapse;border-top-width:1px;border-top-style:solid;border-top-color:rgb(218,223,225)">
																					<tbody>
																						<tr>
																							<td width="100%" height="15px" style="border-collapse:collapse"></td>
																						</tr>
																					</tbody>
																				</table>
																			</td>
																		</tr>
																	</tbody>
																</table>
															</td>
														</tr>
													</tbody>
												</table>
												<table width="640" cellspacing="0" cellpadding="0" border="0" align="center" style="border-spacing:0px;border-collapse:collapse;background-color:rgb(255,255,255);background-position:initial initial;background-repeat:initial initial">
													<tbody>
														<tr>
															<td height="15" width="640" style="border-collapse:collapse;min-width:640px;width:640px">
																<table width="640" cellspacing="0" cellpadding="0" border="0" align="center" style="border-spacing:0px;border-collapse:collapse;width:640px">
																	<tbody>
																		<tr>
																			<td height="15" width="640" style="border-collapse:collapse;min-width:640px;width:640px"></td>
																		</tr>
																	</tbody>
																</table>
															</td>
														</tr>
													</tbody>
												</table>
												<table align="center" width="640" cellpadding="0" cellspacing="0" border="0" style="border-spacing:0px;border-collapse:collapse;width:640px">
													<tbody>
														<tr>
															<td width="640" style="border-collapse:collapse;min-width:640px;width:640px">
																<table width="640" cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff" style="border-spacing:0px;border-collapse:collapse;width:640px">
																	<tbody>
																		<tr>
																			<td style="border-collapse:collapse;padding:0px 50px 30px;width:540px">
																				<table width="260" cellpadding="0" cellspacing="0" border="0" align="left" style="border-spacing:0px;border-collapse:collapse;width:260px">
																					<tbody>
																						<tr>
																							<td align="left" style="border-collapse:collapse;padding:0px;vertical-align:middle;font-family:Arial;font-size:11px;color:rgb(189,195,199)">
																								<p style="margin:0px 0px 5px;padding:0px;line-height:19.5px;font-family:Arial;font-weight:bold;font-size:13px;color:rgb(52,73,94)">Yaveh Transport</p>
																								<div style="padding:0px;line-height:16.5px;margin:0px"><a href="http://yavehtransport.com.pe/" style="word-wrap:break-word" target="_blank">www.yavehtransport.com.pe</a></div>
																							</td>
																						</tr>
																					</tbody>
																				</table>
																				<table width="260" cellpadding="0" cellspacing="0" border="0" align="right" style="border-spacing:0px;border-collapse:collapse;width:260px">
																					<tbody>
																						<tr>
																							<td style="border-collapse:collapse;text-align:right;padding:0px 0px 15px;font-family:Arial;font-size:11px;color:rgb(189,195,199)">
																								<table cellpadding="0" cellspacing="0" border="0" style="border-spacing:0px;border-collapse:collapse;float:right">
																									<tbody>
																										<tr>
																											<td width="10" style="border-collapse:collapse"></td>
																											<td style="border-collapse:collapse"><a href="https://www.facebook.com/iconutopia" style="word-wrap:break-word;color:rgb(189,195,199);border:none" target="_blank"><img border="0" src="https://static1.mailerlite.com/images/social-icons/set4/facebook.png"></a></td>
																											<td width="10" style="border-collapse:collapse"></td>
																											<td style="border-collapse:collapse"><a href="https://twitter.com/JustasDesign" style="word-wrap:break-word;color:rgb(189,195,199);border:none" target="_blank"><img border="0" src="https://static1.mailerlite.com/images/social-icons/set4/twitter.png"></a></td>
																											<td width="10" style="border-collapse:collapse"></td>
																										</tr>
																									</tbody>
																								</table>
																							</td>
																						</tr>
																						<tr>
																							<td align="right" style="border-collapse:collapse;padding:0px;font-family:Arial;font-size:11px;color:rgb(189,195,199)"></td>
																						</tr>
																					</tbody>
																				</table>
																			</td>
																		</tr>
																	</tbody>
																</table>
															</td>
														</tr>
													</tbody>
												</table>
												<table width="640" cellspacing="0" cellpadding="0" border="0" align="center" style="border-spacing:0px;border-collapse:collapse;width:640px">
													<tbody>
														<tr>
															<td width="640" height="30" style="border-collapse:collapse"></td>
														</tr>
													</tbody>
												</table>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<br>
					</div>
				</div>
			</div>
		</div>
		<br>
	</div>
</body></html>';				
				$email_from = "ventas@conmetal.pe";
				$email_to = $_POST['email'];
				$email_subject = "ENVIO DE CONTRASEÑA - JAVEH TRANSPORT: " . $nick;
				
				// Cabecera que especifica que es un HMTL
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				
				// Cabeceras adicionales
				//$headers .= 'From: Atencion al Usuario -  <ventas@conmetal.pe>' . "\r\n";
				//$headers .= 'Cc: archivotarifas@example.com' . "\r\n";
				//$headers .= 'Bcc: copiaoculta@example.com' . "\r\n";
				$headers .= 'From: Atencion al Usuario -  <ventas@conmetal.pe>' . "\r\n".
				'Reply-To: '.$email_to."\r\n" .
				'X-Mailer: PHP/' . phpversion();
				@mail($email_to, $email_subject, $email_message, $headers);
				$mensaje = "<p>Su contraseña ha sido enviada satisfactoriamente a su email, revise por favor</p>";
				$mensaje .= "<p>Algunos Gestores de correo, enviaran este mensaje a la carpeta SPAM o NO DESEADO</p>";
				echo $mensaje;
				//header("Location:../recupera_contrasena.php?error=".$mensaje);
			}
			else {
				$mensaje = "el usuario ha sido bloqueado, contacte al administrador del sistema";
				header("Location:../recupera_contrasena.php?error=".$mensaje);
			}
		} 
	} 
	else {
		$mensaje = "Error el usuario no existe";
		header("Location:../recupera_contrasena.php?error=".$mensaje);
	}
	$resultado->close();	
?>					