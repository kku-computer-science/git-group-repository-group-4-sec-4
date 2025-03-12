*** Settings ***   
Library          SeleniumLibrary
Test Teardown    Close Browser

*** Variables ***
${BROWSER}           chrome
${HOME_URL}          https://cs0404.cpkkuhost.com/detail/eyJpdiI6ImlvL1Z4UzFOZ1hUbXFDOTV6Q2ZCZnc9PSIsInZhbHVlIjoiN1QwS3p2eUhRMTJsT2ZRMDd2SHNCZz09IiwibWFjIjoiZWUyOGFlZjk3NGU0ODY5YTlkM2IxYzc1NDQ1OGI5YWU3NDlkYTkwM2U2YmFjNzBhNmQ2YTBmZGRiNDU0ODNmMiIsInRhZyI6IiJ9
${WAIT_TIME}         3s
${WEBDRIVER_PATH}    /Users/ptpspp/Documents/GitHub/git-group-repository-group-4-sec-4/sprint3/test/chromedriver-mac-arm64/chromedriver

# เปลี่ยนภาษา (ตัวเลือกใน dropdown)
${LANG_DROPDOWN_TOGGLE}    xpath=//a[@id="navbarDropdownMenuLink"]
${LANG_TO_THAI}       xpath=//div[contains(@class, 'dropdown-menu')]//a[contains(@href, '/lang/th')]
${LANG_TO_CHINESE}    xpath=//div[contains(@class, 'dropdown-menu')]//a[contains(@href, '/lang/zh')]

# เปลี่ยนเมนู
${CLICK_SCOPUS}    xpath=//button[@id="scopus-tab"]
${CLICK_PATENT_TAB}    xpath=//button[@id="patent-tab"]

# ตรวจสอบข้อความที่ต้องปรากฏหลังจากเปลี่ยนภาษา
@{TEXT_TH}    
...    รศ.ดร. ปัญญาพล หอระตะ
...    อีเมลล์: punhor1@kku.ac.th
...    การศึกษา
...    2528 วท.บ. (คณิตศาสตร์) มหาวิทยาลัยขอนแก่น
...    2535 วท.ม. (วิทยาศาสตร์คอมพิวเตอร์) จุฬาลงกรณ์มหาวิทยาลัย
...    2555 ปร.ด. (วิทยาการคอมพิวเตอร์) มหาวิทยาลัยขอนแก่น
...    ภานุวัฒน์ แก้วบัว

@{TEXT_TH_SCOPUS}    
...    ภานุวัฒน์ แก้วบัว , ปัญญาพล หอระตะ
...    ยนิกา กองศร , ปกฤต มุสิกวาน , ปัญญาพล หอระตะ
...    สุธาสินี เอี่ยมสะอาด , ปัญญาพล หอระตะ คำรณ สุนัติ
...    ยนิกา กองศร , ปกฤต มุสิกวาน , ปัญญาพล หอระตะ คำรณ สุนัติ
...    ปกฤต มุสิกวาน , ยนิกา กองศร , คำรณ สุนัติ ปัญญาพล หอระตะ สิรภัทร เชี่ยวชาญวัฒนา

@{TEXT_TH_PATENT}    
...    ภาษาโปรแกรม (Programming languages)
...    หนังสือ

@{TEXT_ENG}    
...    Assoc. Prof. Dr. Punyaphol Horata Ph.D.
...    Email: punhor1@kku.ac.th
...    Education
...    2528 B.Sc. (Mathematics) Khon Kaen University
...    2535 M.Sc. (Computer Science) Chulalongkorn University
...    2555 D.Sc. (Computer Science) Khon Kaen University

@{TEXT_ENG_SCOPUS}    
...    Panuwat Keawbor , Punyaphol Horata
...    Yanika Kongsorot , Pakarat Musikawan , Punyaphol Horata
...    Suthasinee Iamsa-At , Punyaphol Horata Khamron Sunat
...    Yanika Kongsorot , Pakarat Musikawan , Punyaphol Horata Khamron Sunat
...    Pakarat Musikawan , Yanika Kongsorot , Khamron Sunat Punyaphol Horata Sirapat Chiewchanwattana

@{TEXT_ENG_PATENT}    
...    Punyaphol Horata
...    book

@{TEXT_ZH}    
...    副教授博士 智果 贺田
...    电子邮件: punhor1@kku.ac.th
...    教育
...    2528 理学士（数学） 孔敬大学
...    2535 计算机科学硕士 朱拉隆功大学
...    2555 计算机科学博士 孔敬大学
 
@{TEXT_ZH_SCOPUS}    
...    帕努瓦 克奥博 , 智果 贺田
...    颜妮卡 颜妮卡 , 帕卡拉特 穆斯卡万 , 智果 贺田
...    苏塔西妮 ·艾姆萨阿特 , 智果 贺田 康龙 孙达
...    颜妮卡 颜妮卡 , 帕卡拉特 穆斯卡万 , 智果 贺田 康龙 孙达
...    帕卡拉特 穆斯卡万 , 颜妮卡 颜妮卡 , 康龙 孙达 智果 贺田 诗丽 赵展华

@{TEXT_ZH_PATENT}    
...    智果 贺田
...    書

*** Keywords ***
Open Browser To Home Page
    Open Browser    ${HOME_URL}    ${BROWSER}    executable_path=${WEBDRIVER_PATH}
    Maximize Browser Window

  

Change Language To Thai
    Click Element    ${LANG_DROPDOWN_TOGGLE}
    Sleep    2s
    Wait Until Element Is Enabled    ${LANG_TO_THAI}    timeout=10s
    Click Element    ${LANG_TO_THAI}
    ${PAGE_TEXT}    Get Text    xpath=//body
    # ตรวจสอบข้อความภาษาไทย
    FOR    ${TEXT}    IN    @{TEXT_TH}
        Should Contain    ${PAGE_TEXT}    ${TEXT}
    END
    Log  "Language changed to Thai successfully."    INFO
    Log To Console  "Language changed to Thai successfully."  # แสดงผลบน Console

Change Language To Thai In Scopus
    Click Element    ${CLICK_SCOPUS}
    Sleep    2s
    ${PAGE_TEXT}    Get Text    xpath=//body
    # ตรวจสอบข้อความภาษาไทย
    FOR    ${TEXT}    IN    @{TEXT_TH_SCOPUS}
        Should Contain    ${PAGE_TEXT}    ${TEXT}
    END
    Log  "Language changed to Thai successfully."    INFO
    Log To Console  "Language changed to Thai successfully."  # แสดงผลบน Console

Change Language To Thai In Patent
    Click Element    ${CLICK_PATENT_TAB}
    Sleep    2s
    ${PAGE_TEXT}    Get Text    xpath=//body
    # ตรวจสอบข้อความภาษาไทย
    FOR    ${TEXT}    IN    @{TEXT_TH_PATENT}
        Should Contain    ${PAGE_TEXT}    ${TEXT}
    END
    Log  "Language changed to Thai successfully."    INFO
    Log To Console  "Language changed to Thai successfully."  # แสดงผลบน Console

Change Language To English
    Click Element    ${LANG_DROPDOWN_TOGGLE}
    Sleep    2s
    ${PAGE_TEXT}    Get Text    xpath=//body
    # ตรวจสอบข้อความภาษาไทย
    FOR    ${TEXT}    IN    @{TEXT_ENG}
        Should Contain    ${PAGE_TEXT}    ${TEXT}
    END
    Log  "Language changed to English successfully."

Change Language To Eng In Scopus
    Click Element    ${CLICK_SCOPUS}
    Sleep    2s
    ${PAGE_TEXT}    Get Text    xpath=//body
    FOR    ${TEXT}    IN    @{TEXT_ENG_SCOPUS}
        Should Contain    ${PAGE_TEXT}    ${TEXT}
    END
    Log  "Language changed to Thai successfully."    INFO
    Log To Console  "Language changed to Thai successfully."  # แสดงผลบน Console

Change Language To Eng In Patent
    Click Element    ${CLICK_PATENT_TAB}
    Sleep    2s
    ${PAGE_TEXT}    Get Text    xpath=//body
    # ตรวจสอบข้อความภาษาไทย
    FOR    ${TEXT}    IN    @{TEXT_ENG_PATENT}
        Should Contain    ${PAGE_TEXT}    ${TEXT}
    END
    Log  "Language changed to Thai successfully."    INFO
    Log To Console  "Language changed to Thai successfully."  # แสดงผลบน Console

Change Language To Chinese
    Click Element    ${LANG_DROPDOWN_TOGGLE}
    Sleep    2s
    Wait Until Element Is Enabled    ${LANG_TO_CHINESE}    timeout=10s
    Click Element    ${LANG_TO_CHINESE}
    ${PAGE_TEXT}    Get Text    xpath=//body
    # ตรวจสอบข้อความภาษาไทย
    FOR    ${TEXT}    IN    @{TEXT_ZH}
        Should Contain    ${PAGE_TEXT}    ${TEXT}
    END
    Log  "Language changed to Chinese successfully."

Change Language To Chinese In Scopus
    Click Element    ${CLICK_SCOPUS}
    Sleep    2s
    ${PAGE_TEXT}    Get Text    xpath=//body
    FOR    ${TEXT}    IN    @{TEXT_ZH_SCOPUS}
        Should Contain    ${PAGE_TEXT}    ${TEXT}
    END
    Log  "Language changed to Thai successfully."    INFO
    Log To Console  "Language changed to Thai successfully."  # แสดงผลบน Console

Change Language To Chinese In Patent
    Click Element    ${CLICK_PATENT_TAB}
    Sleep    2s
    ${PAGE_TEXT}    Get Text    xpath=//body
    # ตรวจสอบข้อความภาษาไทย
    FOR    ${TEXT}    IN    @{TEXT_ZH_PATENT}
        Should Contain    ${PAGE_TEXT}    ${TEXT}
    END
    Log  "Language changed to Thai successfully."    INFO
    Log To Console  "Language changed to Thai successfully."  # แสดงผลบน Console

*** Test Cases ***
Admin Login And Change Language To Thai
    Open Browser To Home Page
    Change Language To Thai
    Change Language To Thai In Scopus
    Change Language To Thai In Patent
    Close Browser

Admin Login And Change Language To English
    Open Browser To Home Page
    Change Language To English
    Change Language To Eng In Scopus
    Change Language To Eng In Patent
    Close Browser

Admin Login And Change Language To Chinese
    Open Browser To Home Page
    Change Language To Chinese
    Change Language To Chinese In Scopus
    Change Language To Chinese In Patent
    Close Browser
