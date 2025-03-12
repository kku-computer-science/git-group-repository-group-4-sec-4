*** Settings ***   
Library          SeleniumLibrary
Test Teardown    Close Browser

*** Variables ***
${BROWSER}           chrome
${HOME_URL}          https://cs0404.cpkkuhost.com/login
${WAIT_TIME}         3s
${WEBDRIVER_PATH}    /Users/ptpspp/Documents/GitHub/git-group-repository-group-4-sec-4/test/test_sprint3/chromedriver-mac-arm64/chromedriver

# เปลี่ยนภาษา (ตัวเลือกใน dropdown)
${LANG_DROPDOWN_TOGGLE}    xpath=//a[@id="navbarDropdownMenuLink"]
${LANG_TO_THAI}       xpath=//div[contains(@class, 'dropdown-menu')]//a[contains(@href, '/lang/th')]
${LANG_TO_CHINESE}    xpath=//div[contains(@class, 'dropdown-menu')]//a[contains(@href, '/lang/zh')]

# ตรวจสอบข้อความที่ต้องปรากฏหลังจากเปลี่ยนภาษา
@{TEXT_TH}    
...    เข้าสู่ระบบ
...    ชื่อผู้ใช้  
...    รหัสผ่าน	
...    จดจำฉัน
...    ใช้ KKU-Mail ในการเข้าสู่ระบบ

@{TEXT_ENG}    
...    ACCOUNT LOGIN
...    USERNAME
...    PASSWORD
...    Remember Me	
...    For Username, use KKU-Mail to log in.

@{TEXT_ZH}    
...    登录
...    用户名
...    密码
...    记住我	
...    使用KKU-Mail登录

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


Change Language To English
    Click Element    ${LANG_DROPDOWN_TOGGLE}
    Sleep    2s
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
