#
# prepare-for-gnuplot.pl: convert access log files to gnuplot input
# Raju Varghese. 2007-02-03

use strict;

my $tempFilename    = "/tmp/temp.dat";
my $ipListFilename  = "/tmp/iplist.dat";
my $urlListFilename = "/tmp/urllist.dat";
my $sc="";

my (%ipList, %urlList,@status);

sub ip2int {
        my ($ip) = @_;
        my @ipOctet = split (/\./, $ip);
        my $n = 0;
        foreach (@ipOctet) {
                $n = $n*256 + $_;
        }
        return $n;
}

# prepare temp file to store log lines temporarily
open (TEMP, ">$tempFilename");

# reads log lines from stdin or files specified on command line

while (<>) {
        chomp;
        my ($ip, undef, undef, $time, undef,undef, $url, undef,$status ,undef) = split;
        $time =~ s/\[//;
        next if ($url =~ /(gif|jpg|png|js|css)$/);


        if(substr($status,0,1)=="2"){
            $status=100*256;
        }
        elsif (substr($status,0,1)=="3"){
            $status=100*65536+100*256;
        }
        else {
            $status=100*65536;
        }
        print TEMP "$time $ip $url $sc $status \n";

        $ipList{$ip}++;
        $urlList{$url}++;
}

# process IP addresses

my @sortedIpList = sort {ip2int($a) <=> ip2int($b)} keys %ipList;
my $n = 0;
open (IPLIST, ">$ipListFilename");
foreach (@sortedIpList) {
        ++$n;
        print IPLIST "$n $ipList{$_} $_\n";
        $ipList{$_} = $n;
}
close (IPLIST);

# process URLs

my @sortedUrlList = sort {$urlList {$b} <=> $urlList {$a}} keys %urlList; 
$n = 0;
open (URLLIST, ">$urlListFilename");
foreach (@sortedUrlList) {
        ++$n;
        print URLLIST "$n $urlList{$_} $_\n";
        $urlList{$_} = $n;
}
close (URLLIST);

close (TEMP); open (TEMP, $tempFilename);
while (<TEMP>) {
        chomp;
        my ($time, $ip, $url, $sc) = split;
        print "$ipList{$ip} $time $urlList{$url} $sc\n";
}
close (TEMP);
