#!/usr/local/bin/ruby
#C:/Ruby/bin/ruby.exe
require "cgi"
cgi = CGI.new("html3")  # add HTML generation methods
passage = cgi['passage']
passage = passage.gsub(/\s/,"%20")
book=passage.gsub(/(.+)%20.+$/, "\\1")
book=book.gsub(/%20/, " ")


require "net/http"
version="51"
h = Net::HTTP.new("www.biblegateway.com", 80)
resp, data = h.get("/passage/?search=" + passage + "&version=" + version)

result=data.sub(/.+<div class="result-text-style-normal">(.+?)<\/div>.+/m, "\\1")#get verses from html
result=result.gsub(/<span style="font-variant:small-caps">(.+?)<\/span>/m,"\\1")
result=result.gsub(/<span.+?class="sup">(.+?)<\/span>/m, "SUPERSTART\\1SUPEREND")#remove sup tags and replace for later formatting
result=result.gsub(/\(<a.+?title="See.+?>(.+?)<\/a>\)/m, "")
result=result.sub(/#{book}\s\d*/, "")#remove Book name
result=result.gsub(/\[.+?\]/m, "") #revove notes
result=result.gsub(/(“|”)/m, "\"") #revove smart quotes
result=result.gsub(/—/m, "-") #revove dashes
result=result.gsub(/’/m, "'") #revove apostrophes
result=result.gsub(/(<woj>|<\/woj>)/m, "")#remove word of jesus tags
result=result.gsub(/<li.*?>.+?<\/li>/m, "")#remove footnote lines
result=result.gsub(/<.*?>/m, "")#remove formatting
result=result.gsub(/(\r\n|\n|\r)/,'')#remove extra lines
result=result.gsub(/&nbsp;/,' ')#remove extra spaces
result=result.gsub(/\s\s+/,' ')#remove extra spaces
result=result.gsub(/SUPERSTART/m, "<sup><strong>")
result=result.gsub(/SUPEREND/m, "<\/strong><\/sup>")
result=result.sub(/Footnotes.+/,"") # remove footnote


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
		versions += "<span onclick=\"new Ajax.Updater('passage','/cgi-bin/bible_verseOnly.cgi?passage="+passage+"&version="+version_number+"',{method : 'get'})\">"+version_hash[version_number]+"</span>&nbsp;:&nbsp;"
	end
}
versions.sub(/&nbsp;:&nbsp;$/,"")

cgi.out{
  cgi.html{
    cgi.head{ "\n"+cgi.title{"Bible Passage"} + "\n<script type=\"text/javascript\" src=\"/javascript/prototype1.6.1.js\"></script>" + "\n<link rel=\"stylesheet\" href=\"/css/bible_passage.css\" type=\"text/css\" media=\"screen\" />"} +
    cgi.body{
		"<div id=\"passage\">" +
		result +
    "<br><br>"+
		"<div class=\"bibleLink\">"+
		"Current Bible version:&nbsp;<b>" + version_hash[version] + "</b><br>Choose alternative Bible version:&nbsp;"+
		versions +
		"</div>"+
		"</div>"+
		"<br>Bible verses courtesy of <a href=\"http://www.biblegateway.com\" target=\"_blank\">Biblegateway.com</span>"
    }
  }
}
