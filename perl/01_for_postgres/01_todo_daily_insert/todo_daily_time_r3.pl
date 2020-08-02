use Time::Local;

$period = '[2018-12-02,2018-12-05)';
# $wday   = '("1970-01-01 09:00:00","1970-01-01 10:00:00")';
@wday = ('("1970-01-01 09:00:00","1970-01-01 10:00:00")',
         '("1970-01-01 10:00:00","1970-01-01 11:00:00")',
         '("1970-01-01 11:00:00","1970-01-01 12:00:00")',
         '("1970-01-01 12:00:00","1970-01-01 13:00:00")',
         '("1970-01-01 13:00:00","1970-01-01 14:00:00")',
         '("1970-01-01 14:00:00","1970-01-01 15:00:00")',
         '("1970-01-01 15:00:00","1970-01-01 16:00:00")');

# period_date
$period_start = &strdate_to_timestamp($period, 'start');
$period_end   = &strdate_to_timestamp($period, 'end');

# match format
$time_fm = '..\:..\:..';

for($i = 0;$i < 7; $i++){
  # split data
  @wday_ary = split(/,/,$wday[$i]);
  $wday_ary[0] =~ /$time_fm/p;
  $start_time = ${^MATCH};
  $wday_ary[1] =~ /$time_fm/p;
  $end_time = ${^MATCH};

  given($i){
    when(0){ # sun
      $sun_start = $start_time;
      $sun_end   = $end_time;
      break;
    }
    when(1){ # mon
      $mon_start = $start_time;
      $mon_end   = $end_time;
      break;
    }
    when(2){ # tue
      $tue_start = $start_time;
      $tue_end   = $end_time;
      break;
    }
    when(3){ # wed
      $wed_start = $start_time;
      $wed_end   = $end_time;
      break;
    }
    when(4){ # thu
      $thu_start = $start_time;
      $thu_end   = $end_time;
      break;
    }
    when(5){ # fri
      $fri_start = $start_time;
      $fri_end   = $end_time;
      break;
    }
    when(6){ # sat
      $sat_start = $start_time;
      $sat_end   = $end_time;
      break;
    }
  }
}

while( $period_end >= $period_start){

  (0, 0, 0, 0, 0, 0, $wday, 0) = gmtime($period_start);

  given($wday){
    when(0){ # sun
      $start_time = $sun_start;
      $end_time   = $sun_end;
      break;
    }
    when(1){ # mon
      $start_time = $mon_start;
      $end_time   = $mon_end;
      break;
    }
    when(2){ # tue
      $start_time = $tue_start;
      $end_time   = $tue_end;
      break;
    }
    when(3){ # wed
      $start_time = $wed_start;
      $end_time   = $wed_end;
      break;
    }
    when(4){ # thu
      $start_time = $thu_start;
      $end_time   = $thu_end;
      break;
    }
    when(5){ # fri
      $start_time = $fri_start;
      $end_time   = $fri_end;
      break;
    }
    when(6){ # sat
      $start_time = $sat_start;
      $end_time   = $sat_end;
      break;
    }
  }

  print &gen_insert('todo_daily_time',
                    $period_start, $start_time, $end_time,
                    'big_task',
                    'little_task',
                    'todo_daily') . "\n";

  $period_start += 86400;
}
# -------------------------------------------------------------
# -------------------------------------------------------------
sub strdate_to_timestamp {
  # read only Year, Month, Day
  # OD1 = start/end
  my ($STR_period, $STR_OD1) = @_;

# match format
  $date_fm = '....\-..\-..';

  @period_ary = split(/,/,$STR_period);

  if($STR_OD1 eq "start"){
    $period_ary[0] =~ /$date_fm/p;
    ($year, $mon, $mday) = split(/-/,${^MATCH});
  }
  elsif($STR_OD1 eq "end"){
    $period_ary[1] =~ /$date_fm/p;
    ($year, $mon, $mday) = split(/-/,${^MATCH});
  }
  else{
    return -1;
  }

  return timegm( 0, 0, 0, $mday, $mon-1, $year);
}

# -------------------------------------------------------------
# -------------------------------------------------------------
sub gen_insert{
  my ($STR_table,
      $TS_date, $STR_time_S, $STR_time_E,
      $STR_parent, $STR_child, $STR_todo) = @_;

  ($dmy1, $dmy2, $dmy3, $mday, $mon, $year) = gmtime($TS_date);

  # timestamp format ---> ("1970-01-01 HH:MM:SS,1970-01-01 HH:MM:SS")
  $ret = sprintf("insert into %s values ('(%d-%d-%d %s,%d-%d-%d %s)'::tsrange,%s,%s,%s)",
                 $STR_table,
		 $year+1900, $mon+1, $mday, $STR_time_S,
		 $year+1900, $mon+1, $mday, $STR_time_E,
		 $STR_parent, $STR_child, $STR_todo);
  return $ret;
}
