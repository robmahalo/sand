#!/bin/bash

curl -X "POST" "https://ssb.stetson.edu/ords/ssb/prod/wwckdyna.p_get_crse_unsec" -H "Content-Type: application/x-www-form-urlencoded; charset=utf-8" -d "term_in=202015&sel_subj=dummy&sel_day=dummy&sel_schd=dummy&sel_insm=dummy&sel_camp=dummy&sel_levl=dummy&sel_sess=dummy&sel_instr=dummy&sel_ptrm=dummy&sel_attr=dummy&sel_subj=%25&sel_crse=&sel_title=&sel_attr=%25&sel_attr=%25&sel_camp=%25&sel_levl=%25&sel_ptrm=%25&sel_instr=%25&begin_hh=0&begin_mi=0&begin_ap=a&end_hh=0&end_mi=0&end_ap=a" | python3.8 ParseHTML.py



