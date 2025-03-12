*** Settings ***   
Library          SeleniumLibrary
Test Teardown    Close Browser

*** Variables ***
${BROWSER}           chrome
${HOME_URL}          https://cs0404.cpkkuhost.com/
${WAIT_TIME}         3s
${WEBDRIVER_PATH}    /Users/ptpspp/Documents/GitHub/git-group-repository-group-4-sec-4/test/test_sprint3/chromedriver-mac-arm64/chromedriver

# เปลี่ยนภาษา (ตัวเลือกใน dropdown)
${LANG_DROPDOWN_TOGGLE}    xpath=//a[@id="navbarDropdownMenuLink"]
${LANG_TO_THAI}       xpath=//div[contains(@class, 'dropdown-menu')]//a[contains(@href, '/lang/th')]
${LANG_TO_CHINESE}    xpath=//div[contains(@class, 'dropdown-menu')]//a[contains(@href, '/lang/zh')]

# ปุ่มสำหรับเปิดดูข้อมูล
${CLICK_BEFORE_2019}    xpath=(//div[@id="accordionExample"])[7]

# ตรวจสอบข้อความที่ต้องปรากฏหลังจากเปลี่ยนภาษา
@{TEXT_TH}    
...    สรุป
...    ผลงานตีพิมพ์ (5 ปี ย้อนหลัง)
...    หน้าแรก
...    ผู้วิจัย
...    โครงการวิจัย
...    กลุ่มวิจัย
...    เข้าสู่ระบบ
...    ระบบแนะนำการแพทย์แผนโบราณแบบเฉพาะบุคคลโดยใช้แนวทางออนโทโลยีและการอนุมานตามกฎ
...    การจัดประเภทคำถามเชิงความหมายสำหรับระบบตอบคำถามโดยใช้แนวทางข้อมูลเปิดที่เชื่อมโยง

@{TEXT_ENG}    
...    SUMMARY
...    Publications (In the Last 5 Years)
...    HOME
...    RESEARCHERS 
...    RESEARCH PROJECT
...    RESEARCH GROUP
...    REPORTS
...    LOGIN
...    IT adaptation patterns to enterprise-wide systems
...    An integrated approach to performance evaluation of enterprise resource planning (ERP) system implementation
...    P. Wanchai

@{TEXT_ZH}    
...    总结
...    出版物（近5年）
...    首页
...    研究人员
...    研究项目
...    研究团队
...    报告
...    登录
...    IT adaptation patterns to enterprise-wide systems
...    An integrated approach to performance evaluation of enterprise resource planning (ERP) system implementation
...    P. Wanchai

*** Keywords ***
Open Browser To Home Page
    Open Browser    ${HOME_URL}    ${BROWSER}    executable_path=${WEBDRIVER_PATH}
    Maximize Browser Window

  

Change Language To Thai
    Click Element    ${LANG_DROPDOWN_TOGGLE}
    Sleep    2s

    Wait Until Element Is Enabled    ${LANG_TO_THAI}    timeout=10s
    Click Element    ${LANG_TO_THAI}

    Wait Until Element Is Visible    ${CLICK_BEFORE_2019}    timeout=5s
    Scroll Element Into View    ${CLICK_BEFORE_2019}
    Sleep    1s
    Click Element    ${CLICK_BEFORE_2019}

    ${PAGE_TEXT}    Get Text    xpath=//body
    # ตรวจสอบข้อความภาษาไทย
    FOR    ${TEXT}    IN    @{TEXT_TH}
        Should Contain    ${PAGE_TEXT}    ${TEXT}
    END
    Log  "Language changed to Thai successfully."    INFO
    Log To Console  "Language changed to Thai successfully."  # แสดงผลบน Console


Change Language To English
    Click Element    ${LANG_DROPDOWN_TOGGLE}
    Sleep    2s

    Wait Until Element Is Visible    ${CLICK_BEFORE_2019}    timeout=5s
    Scroll Element Into View    ${CLICK_BEFORE_2019}
    Sleep    1s
    Click Element    ${CLICK_BEFORE_2019}
    
    ${PAGE_TEXT}    Get Text    xpath=//body
    # ตรวจสอบข้อความภาษาไทย
    FOR    ${TEXT}    IN    @{TEXT_ENG}
        Should Contain    ${PAGE_TEXT}    ${TEXT}
    END
    Log  "Language changed to English successfully."

Change Language To Chinese
    Click Element    ${LANG_DROPDOWN_TOGGLE}
    Sleep    2s

    Wait Until Element Is Enabled    ${LANG_TO_CHINESE}    timeout=10s
    Click Element    ${LANG_TO_CHINESE}

    Wait Until Element Is Visible    ${CLICK_BEFORE_2019}    timeout=5s
    Scroll Element Into View    ${CLICK_BEFORE_2019}
    Sleep    1s
    Click Element    ${CLICK_BEFORE_2019}

    ${PAGE_TEXT}    Get Text    xpath=//body
    # ตรวจสอบข้อความภาษาไทย
    FOR    ${TEXT}    IN    @{TEXT_ZH}
        Should Contain    ${PAGE_TEXT}    ${TEXT}
    END
    Log  "Language changed to Chinese successfully."

*** Test Cases ***
Admin Login And Change Language To Thai
    Open Browser To Home Page
    Change Language To Thai
    Close Browser

Admin Login And Change Language To English
    Open Browser To Home Page
    Change Language To English
    Close Browser

Admin Login And Change Language To Chinese
    Open Browser To Home Page
    Change Language To Chinese
    Close Browser
