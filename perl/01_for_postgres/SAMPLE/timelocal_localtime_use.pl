use Time::Local;

$time = time;

($sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $isdst) = localtime(time);

 print $time . "\n";

$year += 1900;
$mon += 1;
# 60s 60m 24h
$oneday = 60 * 60 * 24;

($sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $isdst) = localtime(time);
print "$wday $yday| $year/$mon/$mday $hour:$min:$sec\n";

$time = time() + $oneday;
($sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $isdst) = localtime($time);
print "next day $year/$mon/$mday $hour:$min:$sec\n";

# timelocal (s, m, h, mday, mon, year)
$time = timelocal( 0, 30, 12, 1, 6, 2018);
print $time . "\n";
($sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $isdst) = localtime($time);
$year += 1900;
print "ind $year/$mon/$mday $hour:$min:$sec\n";

# ($sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $isdst) = gmtime(time);

# print $time . "\n";

# print "$wday $yday  $hour:$min:$sec\n";

