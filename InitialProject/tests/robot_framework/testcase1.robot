*** Settings ***
Library    SeleniumLibrary

*** Variables ***
${URL}     http://127.0.0.1:8000/
${CHROME_DRIVER_PATH}    /Users/ptpspp/Documents/GitHub/git-group-repository-group-4-sec-4/InitialProject/tests/robot_framework/chromedriver-mac-arm64/chromedriver

*** Test Cases ***
Open Web Page And Translate to Thai
    [Documentation]    เปิดเว็บและตรวจสอบการเปลี่ยนภาษาไทย
    Open Browser    ${URL}    chrome    executable_path=${CHROME_DRIVER_PATH}
    Title Should Be    ระบบข้อมูลงานวิจัย วิทยาลัยการคอมพิวเตอร์
    
    # คลิกปุ่มเปลี่ยนภาษา
    Click Element    id=navbarDropdownMenuLink

    # เลือกตัวเลือกภาษาแรกใน dropdown โดยใช้ id
    Click Element    id=language-th  # แทนที่ด้วย id ของตัวเลือกภาษาแรกที่ต้องการ
    Sleep    2  # รอให้เว็บโหลดภาษาใหม่

    # ตรวจสอบว่าข้อความเปลี่ยนไปถูกต้อง
    ${translated_text}=    Get Text    id=home
    ${expected_text}=    Set Variable    หน้าแรก  # ข้อความที่ควรเป็นหลังจากเปลี่ยนภาษา

    Should Be Equal    ${translated_text}    ${expected_text}    Test Failed! Expected '${expected_text}', but got '${translated_text}'

    Log    Test Passed! Language translation works correctly.
    Close Browser

Open Web Page And Translate to Chinese
    [Documentation]    เปิดเว็บและตรวจสอบการเปลี่ยนภาษาจีน
    Open Browser    ${URL}    chrome    executable_path=${CHROME_DRIVER_PATH}
    Title Should Be    ระบบข้อมูลงานวิจัย วิทยาลัยการคอมพิวเตอร์
    
    # คลิกปุ่มเปลี่ยนภาษา
    Click Element    id=navbarDropdownMenuLink

    # เลือกตัวเลือกภาษาแรกใน dropdown โดยใช้ id
    Click Element    id=language-zh  # แทนที่ด้วย id ของตัวเลือกภาษาแรกที่ต้องการ
    Sleep    2  # รอให้เว็บโหลดภาษาใหม่

    # ตรวจสอบว่าข้อความเปลี่ยนไปถูกต้อง
    ${translated_text}=    Get Text    id=home
    ${expected_text}=    Set Variable    首页  # ข้อความที่ควรเป็นหลังจากเปลี่ยนภาษา

    Should Be Equal    ${translated_text}    ${expected_text}    Test Failed! Expected '${expected_text}', but got '${translated_text}'

    Log    Test Passed! Language translation works correctly.
    Close Browser

Open Web Page And Translate to English
    [Documentation]    เปิดเว็บและตรวจสอบการเปลี่ยนภาษาอังกฤษ
    Open Browser    ${URL}    chrome    executable_path=${CHROME_DRIVER_PATH}
    Title Should Be    ระบบข้อมูลงานวิจัย วิทยาลัยการคอมพิวเตอร์

    # ตรวจสอบว่าข้อความเปลี่ยนไปถูกต้อง
    ${translated_text}=    Get Text    id=home
    ${expected_text}=    Set Variable    Home  # ข้อความที่ควรเป็นหลังจากเปลี่ยนภาษา

    Should Be Equal    ${translated_text}    ${expected_text}    Test Failed! Expected '${expected_text}', but got '${translated_text}'

    Log    Test Passed! Language translation works correctly.
    Close Browser
