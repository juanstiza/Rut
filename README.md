### Usage

```php
use JuanStiza\Rut\Rut;

$rut = new Rut(1234567,8);

print_r( $rut->dv );
/* '8' */

print_r( $rut->rut );
/* '1234567' */

print_r( $rut->isValid );
/* false */

$otherRut = new Rut(11.111.111-1);
print_r( $otherRut->isValid );}
/* true */

$yetAnotherRut = new Rut('111111111');
print_r( $yetAnotherRut->isValid );}
/* true */

```