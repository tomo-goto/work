
# ($sec, $min, $hour, $mday, $mon, $year) = localtime('2018-12-01 10:00:00');
# ($sec, $min, $hour, $mday, $mon, $year) = localtime(time);
# ($sec, $min, $hour, $mday, $mon, $year) = gmtime(0);

($sec, $min, $hour) = gmtime(3661);
print sprintf("sec:%d, min:%d, hour:%d"
              ,$sec, $min, $hour) . "\n";


#print sprintf("sec:%d, min:%d, hour:%d, day:%d, mon:%d, year:%d,"
#              ,$sec, $min, $hour, $mday, $mon+1, $year+1900) . "\n";
