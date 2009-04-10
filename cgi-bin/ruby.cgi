#!/usr/local/bin/ruby
ENV['GEM_PATH']="/home/southorg/ruby/gems:/usr/local/lib/ruby/gems/1.8"
require "rubygems"
require_gem 'scrapi'
require "net/http"

h = Net::HTTP.new("www.biblegateway.com", 80)
resp, data = h.get("/passage/?search=john%2014:5&version=51")

passage_result= Scraper.define do
  process "div.result-text-style-normal", :passage => :text

  result :passage
end

result=passage_result.scrape(data)

require "cgi"

cgi = CGI.new("html3")  # add HTML generation methods
cgi.out{
  cgi.html{
    cgi.head{ "\n"+cgi.title{"Bible Passasge"} } +
    cgi.body{ result
    }
  }
}