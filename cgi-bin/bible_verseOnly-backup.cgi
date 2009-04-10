#!/usr/local/bin/ruby
require "cgi"
cgi = CGI.new("html3")  # add HTML generation methods
passage = cgi['passage']
passage = passage.gsub(/\s/,"%20")
book=passage.gsub(/(.+)%20.+$/, "\\1")
book=book.gsub(/%20/, " ")
version = cgi['version']

ENV['GEM_PATH']="/home/southorg/ruby/gems:/usr/local/lib/ruby/gems/1.8"
require "rubygems"
require_gem 'scrapi'
require "net/http"

h = Net::HTTP.new("www.biblegateway.com", 80)
resp, data = h.get("/passage/?search=" + passage + "&version=" + version)

passage_result= Scraper.define do
  process "div.result-text-style-normal", :passage => :text

  result :passage
end

result=passage_result.scrape(data)
result=result.gsub(/(\r\n|\n|\r)/,'[[[NEWLINE]]]')
result=result.sub(/#{book}\s\d*/, "")
result=result.gsub(/(\d{1,2})/,"<sup><b>\\1&nbsp;</b></sup>")
result=result.gsub(/\[.\]/,"")
result=result.gsub(/Footnotes.+/,"")
result=result.gsub('[[[NEWLINE]]]',"\n")


version_hash={
			"45"=>"Amplified",
			"46"=>"CEV",
			"31"=>"NKJV",
			"64"=>"NIV",
			"51"=>"NLT"
			}

versions=""
version_hash.each_key {|version_number|
	if (version_number != version)
		versions += "<span onclick=\"$('#passage').load('/cgi-bin/bible_verseOnly.cgi?passage="+passage+"&version="+version_number+"')\">"+version_hash[version_number]+"</span>&nbsp;:&nbsp;"
	end
}
versions.sub(/&nbsp;:&nbsp;$/,"")

print result + "<br><br><div class=\"bibleLink\">"+ "Current Bible version:&nbsp;<b>" + version_hash[version] + "</b><br>Choose alternative Bible version:&nbsp;"+versions +"</div>\n"
