use Time::Local;

$period = '[2018-12-02,2018-12-31)';
$wday   = '("1970-01-01 09:00:00","1970-01-01 10:00:00")';

# match format
$date_fm = '....\-..\-..';
$time_fm = '..:..:..';

# split data
@period_ary = split(/,/,$period);
$period_ary[0] =~ /$date_fm/p;
($year, $mon, $mday) = split(/-/,${^MATCH});

@wday_ary = split(/,/,$wday);
$wday_ary[0] =~ /$time_fm/p;
($hour_S, $min_S, $sec_S) = split(/-/,${^MATCH});
$wday_ary[1] =~ /$time_fm/p;
($hour_E, $min_E, $sec_E) = split(/-/,${^MATCH});

# pointer
$period_datePointer = timelocal( 0, 0, 0, $mday, $mon-1, $year);
$wday_start = timegm( $sec_S, $min_S, $hour_S, 1, 0, 1970);
$wday_end   = timegm( $sec_E, $min_E, $hour_E, 1, 0, 1970);
print "$hour_S, $min_S, $sec_S, $hour_E, $min_E, $sec_E\n";
print "wday_start:$wday_start, end:$wday_end\n";

print &gen_insert('todo_daily_time',
                  $period_datePointer, $wday_start, $wday_end,
		  'big_task',
		  'little_task',
		  'todo_daily') . "\n";

# -------------------------------------------------------------
# -------------------------------------------------------------
sub gen_insert(){
  my ($STR_table,
      $TS_date, $TS_wday_start, $TS_wday_end,
      $STR_parent,
      $STR_child,
      $STR_todo) = @_;

  ($dmy1, $dmy2, $dmy3, $mday, $mon, $year) = gmtime($TS_date);
  ($sec_S, $min_S, $hour_S) = gmtime($TS_wday_start);
  ($sec_E, $min_E, $hour_E) = gmtime($TS_wday_end);

  # timestamp format ---> ("1970-01-01 HH:MM:SS,1970-01-01 HH:MM:SS")
  return sprintf("insert into %s values (
                 '(%d-%d-%d %02d:%02d:%02d, %d-%d-%d %02d:%02d:%02d)'::tsrange,
                 %s, %s, %s)",
                 $STR_table,
		 $year+1900, $mon+1, $mday, $hour_S, $min_S, $sec_S,
		 $year+1900, $mon+1, $mday, $hour_E, $min_E, $sec_E,
		 $STR_parent, $STR_child, $STR_todo);
}
